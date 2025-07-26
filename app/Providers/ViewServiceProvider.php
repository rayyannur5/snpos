<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.main', 'layouts.sidebar'], function ($view) {
            // Pastikan user sudah login
            if (auth()->check()) {
                $user = auth()->user();

                // Buat cache key yang unik untuk role user
                $cacheKey = 'menus_for_role_' . $user->level;

                // Ambil menu dari cache, atau query ke DB jika tidak ada
                $accessibleMenus = [];
                    // Eager load relasi menus dari role user
                if($user->level == 1) {
                    $accessibleMenus = collect(DB::select("select * from modules where status != 'N' order by ordinal"));
                } else {
                    $accessibleMenus = collect(DB::select("
                        select
                            modules.*
                        from modules
                        join module_levels ml on ml.module_id = modules.id
                        where ml.level_id = $user->level
                        order by modules.ordinal
                    "));
                }

                $accessibleMenus = $this->buildMenuTree($accessibleMenus);

//                dd($accessibleMenus);
                // Bagikan variabel $accessibleMenus ke view
                $view->with('accessibleMenus', $accessibleMenus);
            } else {
                // Jika user belum login, bagikan koleksi kosong
                $view->with('accessibleMenus', collect());
            }
        });
    }

    private function buildMenuTree(Collection $elements, int $parentId = 0): Collection
    {
        $branch = new Collection();

        // Ambil semua anak dari parentId saat ini
        $children = $elements->where('parent', $parentId);

        foreach ($children as $child) {
            // Untuk setiap anak, cari lagi anak-anaknya (rekursif)
            $child->children = $this->buildMenuTree($elements, $child->id);
            $branch->push($child);
        }

        return $branch;
    }
}
