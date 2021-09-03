<?php

namespace KitLoong\PowerJoins\Tests;

use KitLoong\PowerJoins\Tests\Models\Post;
use KitLoong\PowerJoins\Tests\Models\User;
use KitLoong\PowerJoins\Tests\Models\Image;
use KitLoong\PowerJoins\Tests\Models\Comment;
use KitLoong\PowerJoins\Tests\Models\Category;
use KitLoong\PowerJoins\Tests\Models\UserProfile;

class SoftDeletesTest extends TestCase
{
    /** @test */
    public function it_can_disable_soft_deletes()
    {
        // making sure the query doesn't fail
        UserProfile::query()
            ->joinRelationship('user', function ($join) {
                $join->withTrashed();
            })->get();

        $query = UserProfile::query()
            ->joinRelationship('user', function ($join) {
                $join->withTrashed();
            })
            ->toSql();

        $this->assertStringContainsString(
            'inner join "users" on "user_profiles"."user_id" = "users"."id"',
            $query
        );

        $this->assertStringNotContainsString(
            '"users"."deleted_at" is null',
            $query
        );
    }

    /** @test */
    public function it_can_include_only_trashed()
    {
        UserProfile::query()
            ->joinRelationship('user', function ($join) {
                $join->onlyTrashed();
            })
            ->get();

        $query = UserProfile::query()
            ->joinRelationship('user', function ($join) {
                $join->onlyTrashed();
            })
            ->toSql();

        $this->assertStringContainsString(
            'inner join "users" on "user_profiles"."user_id" = "users"."id"',
            $query
        );

        $this->assertStringContainsString(
            '"users"."deleted_at" is not null',
            $query
        );
    }
}
