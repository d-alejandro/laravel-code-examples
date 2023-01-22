<?php

namespace App\Http\Requests;

use App\DTO\IndexOrderPaginationDTO;
use App\DTO\IndexOrderRequestDTO;
use App\Enums\OrderSortColumn;
use App\Enums\OrderStatus;
use App\Enums\SortType;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start' => 'required|integer|min:0',
            'end' => 'required|integer|min:1',
            'sort_column' => 'required|string|in:'
                . $this->convertArrayToString($this->getSortTypes(OrderSortColumn::cases())),
            'sort_type' => 'required|string|in:' . $this->convertArrayToString($this->getSortTypes(SortType::cases())),
            'ids' => 'sometimes|required|array|exists:' . Order::TABLE_NAME . ',' . Order::COLUMN_ID,
            'ids.*' => 'required|integer|min:1',
            'rental_date' => 'sometimes|required|date',
            'is_confirmed' => 'sometimes|required|string|in:true,false',
            'is_checked' => 'sometimes|required|string|in:true,false',
            'order_status' => 'sometimes|required|string|in:' .
                $this->convertArrayToString($this->getSortTypes(OrderStatus::cases())),
            'user_name' => 'sometimes|required|string',
            'agency_name' => 'sometimes|required|string',
            'admin_note' => 'sometimes|required|string|in:true,false',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
        ];
    }

    private function convertArrayToString(array $array): string
    {
        return implode(',', $array);
    }

    private function getSortTypes(array $enumCases): array
    {
        return array_column($enumCases, 'value');
    }

    public function getValidated(): IndexOrderRequestDTO
    {
        $data = $this->validated();

        $indexOrderPaginationDTO = new IndexOrderPaginationDTO(
            $data['start'],
            $data['end'],
            OrderSortColumn::from($data['sort_column']),
            SortType::from($data['sort_type']),
            $data['ids'] ?? null,
        );

        return new IndexOrderRequestDTO(
            $indexOrderPaginationDTO,
            $data['rental_date'] ?? null,
            $data['user_name'] ?? null,
            $data['agency_name'] ?? null,
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['order_status'] ?? null,
            $data['is_confirmed'] ?? null,
            $data['is_checked'] ?? null,
            $data['admin_note'] ?? null,
        );
    }
}
