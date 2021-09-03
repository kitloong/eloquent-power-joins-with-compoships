<?php

namespace KitLoong\PowerJoins\Mixins;

use Kirschbaum\PowerJoins\Mixins\RelationshipsExtraMethods as Base;

/**
 * @method getModel
 */
class RelationshipsExtraMethods extends Base
{
    /**
     * Perform the JOIN clause for the BelongsTo (or similar) relationships.
     */
    protected function performJoinForEloquentPowerJoinsForBelongsTo()
    {
        return function ($query, $joinType, $callback = null, $alias = null, bool $disableExtraConditions = false) {
            $joinedTable = $this->query->getModel()->getTable();
            $parentTable = $this->getTableOrAliasForModel($this->parent, $this->parent->getTable());

            $query->{$joinType}($joinedTable, function ($join) use ($callback, $joinedTable, $parentTable, $alias, $disableExtraConditions) {
                if ($alias) {
                    $join->as($alias);
                }

                if (is_array($this->foreignKey)) {
                    foreach ($this->foreignKey as $i => $fk) {
                        $join->on(
                            "{$parentTable}.{$fk}",
                            '=',
                            "{$joinedTable}.{$this->ownerKey[$i]}"
                        );
                    }
                } else {
                    $join->on(
                        "{$parentTable}.{$this->foreignKey}",
                        '=',
                        "{$joinedTable}.{$this->ownerKey}"
                    );
                }

                if ($disableExtraConditions === false && $this->usesSoftDeletes($this->query->getModel())) {
                    $join->whereNull("{$joinedTable}.{$this->query->getModel()->getDeletedAtColumn()}");
                }

                if ($disableExtraConditions === false) {
                    $this->applyExtraConditions($join);
                }

                if ($callback && is_callable($callback)) {
                    $callback($join);
                }
            }, $this->query->getModel());
        };
    }

    /**
     * Perform the JOIN clause for the HasMany (or similar) relationships.
     */
    protected function performJoinForEloquentPowerJoinsForHasMany()
    {
        return function ($builder, $joinType, $callback = null, $alias = null, bool $disableExtraConditions = false) {
            $joinedTable = $alias ?: $this->query->getModel()->getTable();
            $parentTable = $this->getTableOrAliasForModel($this->parent, $this->parent->getTable());

            $builder->{$joinType}($this->query->getModel()->getTable(), function ($join) use ($callback, $joinedTable, $parentTable, $alias, $disableExtraConditions) {
                if ($alias) {
                    $join->as($alias);
                }

                if (is_array($this->foreignKey)) {
                    foreach ($this->foreignKey as $i => $fk) {
                        $join->on(
                            $fk,
                            '=',
                            "{$parentTable}.{$this->localKey[$i]}"
                        );
                    }
                } else {
                    $join->on(
                        $this->foreignKey,
                        '=',
                        "{$parentTable}.{$this->localKey}"
                    );
                }

                if ($disableExtraConditions === false && $this->usesSoftDeletes($this->query->getModel())) {
                    $join->whereNull(
                        "{$joinedTable}.{$this->query->getModel()->getDeletedAtColumn()}"
                    );
                }

                if ($disableExtraConditions === false) {
                    $this->applyExtraConditions($join);
                }

                if ($callback && is_callable($callback)) {
                    $callback($join);
                }
            }, $this->query->getModel());
        };
    }
}
