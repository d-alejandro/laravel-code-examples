<?php

use App\Repositories\Query\Expressions\JoinClauseExpression;
use App\Repositories\Query\Expressions\WhereEqualExpression;
use App\Repositories\Query\Expressions\WhereDateExpression;
use App\Repositories\Query\Expressions\WhereInIdsExpression;
use App\Repositories\Query\Expressions\WhereLikeExpression;
use App\Repositories\Query\Expressions\PaginationExpression;

return [
    WhereEqualExpression::WHERE_EQUAL => WhereEqualExpression::class,
    PaginationExpression::PAGINATION => PaginationExpression::class,
    WhereInIdsExpression::WHERE_IN_IDS => WhereInIdsExpression::class,
    WhereDateExpression::WHERE_DATE_BETWEEN => WhereDateExpression::class,
    WhereDateExpression::WHERE_DATE_EQUAL => WhereDateExpression::class,
    WhereDateExpression::WHERE_DATE_GREATER_THAN_OR_EQUAL => WhereDateExpression::class,
    WhereDateExpression::WHERE_DATE_LESS_THAN_OR_EQUAL => WhereDateExpression::class,
    WhereLikeExpression::WHERE_LIKE_CENTER => WhereLikeExpression::class,
    WhereLikeExpression::WHERE_LIKE_LEFT => WhereLikeExpression::class,
    JoinClauseExpression::JOIN_CLAUSE => JoinClauseExpression::class,
];
