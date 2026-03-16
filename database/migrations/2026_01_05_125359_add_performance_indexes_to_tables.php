<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Categories indexes
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!$this->hasIndex('categories', 'categories_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('categories', 'categories_sort_order_index')) {
                    $table->index('sort_order');
                }
            });
        }

        // Cruise Experiences indexes (group_key already has index)
        if (Schema::hasTable('cruise_experiences')) {
            Schema::table('cruise_experiences', function (Blueprint $table) {
                if (!$this->hasIndex('cruise_experiences', 'cruise_experiences_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('cruise_experiences', 'cruise_experiences_sort_order_index')) {
                    $table->index('sort_order');
                }
            });
        }

        // Blogs indexes
        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (!$this->hasIndex('blogs', 'blogs_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('blogs', 'blogs_published_at_index')) {
                    $table->index('published_at');
                }
                if (!$this->hasIndex('blogs', 'blogs_sort_order_index')) {
                    $table->index('sort_order');
                }
                if (!$this->hasIndex('blogs', 'blogs_status_published_at_index')) {
                    $table->index(['status', 'published_at']);
                }
                if (!$this->hasIndex('blogs', 'blogs_status_show_on_homepage_index')) {
                    $table->index(['status', 'show_on_homepage']);
                }
            });
        }

        // Tours indexes
        if (Schema::hasTable('tours')) {
            Schema::table('tours', function (Blueprint $table) {
                if (!$this->hasIndex('tours', 'tours_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('tours', 'tours_sort_order_index')) {
                    $table->index('sort_order');
                }
                if (!$this->hasIndex('tours', 'tours_status_sort_order_index')) {
                    $table->index(['status', 'sort_order']);
                }
            });
        }

        // Pages indexes (if status column exists)
        if (Schema::hasTable('pages') && Schema::hasColumn('pages', 'status')) {
            Schema::table('pages', function (Blueprint $table) {
                if (!$this->hasIndex('pages', 'pages_status_index')) {
                    $table->index('status');
                }
            });
        }

        // Announcements indexes
        if (Schema::hasTable('announcements')) {
            Schema::table('announcements', function (Blueprint $table) {
                if (!$this->hasIndex('announcements', 'announcements_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('announcements', 'announcements_sort_order_index')) {
                    $table->index('sort_order');
                }
            });
        }

        // Galleries indexes
        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                if (!$this->hasIndex('galleries', 'galleries_status_index')) {
                    $table->index('status');
                }
                if (!$this->hasIndex('galleries', 'galleries_published_at_index')) {
                    $table->index('published_at');
                }
                if (!$this->hasIndex('galleries', 'galleries_sort_order_index')) {
                    $table->index('sort_order');
                }
                if (!$this->hasIndex('galleries', 'galleries_status_published_at_index')) {
                    $table->index(['status', 'published_at']);
                }
                if (!$this->hasIndex('galleries', 'galleries_status_show_on_homepage_index')) {
                    $table->index(['status', 'show_on_homepage']);
                }
            });
        }
    }

    /**
     * Check if index exists
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();

        $result = $connection->select(
            "SELECT COUNT(*) as count
             FROM information_schema.statistics
             WHERE table_schema = ?
             AND table_name = ?
             AND index_name = ?",
            [$databaseName, $table, $indexName]
        );

        return $result[0]->count > 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Categories indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['sort_order']);
        });

        // Cruise Experiences indexes
        Schema::table('cruise_experiences', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['group_key']);
        });

        // Blogs indexes
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['status', 'show_on_homepage']);
        });

        // Tours indexes
        Schema::table('tours', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['status', 'sort_order']);
        });

        // Pages indexes
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        // Announcements indexes
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['sort_order']);
        });

        // Galleries indexes
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['status', 'show_on_homepage']);
        });
    }
};
