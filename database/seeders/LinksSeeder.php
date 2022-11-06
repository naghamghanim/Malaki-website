<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Link;

class LinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Products
        $link = Link::create([
            'title'         => 'المنتجات',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-list'
        ]);
        Link::create([
            'title'         => 'ادارة المنتجات',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'products.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'اضافة منتج',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'products.create',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'تصنيفات المنتجات',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'category.index',
            'icon'          => ''
        ]);

        //Static Pages
        $link = Link::create([
            'title'         => 'الصفحات الثابتة',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-file'
        ]);
        Link::create([
            'title'         => 'ادارة الصفحات',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'static-page.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'اضافة صفحة جديدة',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'static-page.create',
            'icon'          => ''
        ]);


        
        //Slider
        $link = Link::create([
            'title'         => 'الشرائح الرئيسية',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-tv'
        ]);
        Link::create([
            'title'         => 'ادارة الشرائح',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'slider.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'اضافة شريحة جديدة',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'slider.create',
            'icon'          => ''
        ]);

        
        //Users
        $link = Link::create([
            'title'         => 'المستخدمين',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-users'
        ]);
        Link::create([
            'title'         => 'ادارة المستخدمين',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'user.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'اضافة مستخدم جديدة',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'user.create',
            'icon'          => ''
        ]);



        
        //Services
        $link = Link::create([
            'title'         => 'الخدمات',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-cog'
        ]);
        Link::create([
            'title'         => 'ادارة الخدمات',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'service.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'اضافة خدمة جديدة',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'service.create',
            'icon'          => ''
        ]);



        
        //Orders
        $link = Link::create([
            'title'         => 'الطلبات',
            'show_in_menu'  => 1,
            'parent_id'     => 0,
            'route'         => '',
            'icon'          => 'fa fa-bars'
        ]);
        Link::create([
            'title'         => 'ادارة الطلبات',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'order.index',
            'icon'          => ''
        ]);
        Link::create([
            'title'         => 'الزبائن',
            'show_in_menu'  => 1,
            'parent_id'     => $link->id,
            'route'         => 'customer.index',
            'icon'          => ''
        ]);
    }
}
