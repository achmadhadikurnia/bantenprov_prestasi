# Prestasi

[![Join the chat at https://gitter.im/prestasi/Lobby](https://badges.gitter.im/prestasi/Lobby.svg)](https://gitter.im/prestasi/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/prestasi/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/prestasi/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/prestasi/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/prestasi/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/prestasi/v/stable)](https://packagist.org/packages/bantenprov/prestasi)
[![Total Downloads](https://poser.pugx.org/bantenprov/prestasi/downloads)](https://packagist.org/packages/bantenprov/prestasi)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/prestasi/v/unstable)](https://packagist.org/packages/bantenprov/prestasi)
[![License](https://poser.pugx.org/bantenprov/prestasi/license)](https://packagist.org/packages/bantenprov/prestasi)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/prestasi/d/monthly)](https://packagist.org/packages/bantenprov/prestasi)
[![Daily Downloads](https://poser.pugx.org/bantenprov/prestasi/d/daily)](https://packagist.org/packages/bantenprov/prestasi)

Prestasi

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/prestasi:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/prestasi
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/prestasi.git
```

#### Edit `config/app.php` :

```php
'providers' => [
    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //...
    Bantenprov\Prestasi\PrestasiServiceProvider::class,
    //...
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Lakukan publish semua komponen :

```bash
$ php artisan vendor:publish --tag=prestasi-publish
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovPrestasiSeeder
```

#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //...
        // Jenis Prestasi
        {
            name: 'Jenis Prestasi',
            link: '/dashboard/jenis-prestasi',
            icon: 'fa fa-angle-double-right'
        },
        // Master Prestasi
        {
            name: 'Master Prestasi',
            link: '/dashboard/master-prestasi',
            icon: 'fa fa-angle-double-right'
        },
        // Prestasi
        {
            name: 'Prestasi',
            link: '/dashboard/prestasi',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
        // Jenis Prestasi
        {
            name: 'Jenis Prestasi',
            link: '/admin/jenis-prestasi',
            icon: 'fa fa-angle-double-right'
        },
        // Master Prestasi
        {
            name: 'Master Prestasi',
            link: '/admin/master-prestasi',
            icon: 'fa fa-angle-double-right'
        },
        // Prestasi
        {
            name: 'Prestasi',
            link: '/admin/prestasi',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//... Jenis Prestasi ...//

import JenisPrestasiAdminShow from '~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasiAdmin.show.vue';
Vue.component('jenis-prestasi-admin', JenisPrestasiAdminShow);

//... Echarts Jenis Prestasi ...//

import JenisPrestasi from '~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasi.chart.vue';
Vue.component('jenis-prestasi-echarts', JenisPrestasi);

import JenisPrestasiKota from '~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasiKota.chart.vue';
Vue.component('jenis-prestasi-echarts-kota', JenisPrestasiKota);

import JenisPrestasiTahun from '~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasiTahun.chart.vue';
Vue.component('jenis-prestasi-echarts-tahun', JenisPrestasiTahun);

//... Mini Bar Charts Jenis Prestasi ...//

import JenisPrestasiBar01 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiBar01.vue';
Vue.component('jenis-prestasi-bar-01', JenisPrestasiBar01);

import JenisPrestasiBar02 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiBar02.vue';
Vue.component('jenis-prestasi-bar-02', JenisPrestasiBar02);

import JenisPrestasiBar03 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiBar03.vue';
Vue.component('jenis-prestasi-bar-03', JenisPrestasiBar03);

//... Mini Pie Charts Jenis Prestasi ...//

import JenisPrestasiPie01 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiPie01.vue';
Vue.component('jenis-prestasi-pie-01', JenisPrestasiPie01);

import JenisPrestasiPie02 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiPie02.vue';
Vue.component('jenis-prestasi-pie-02', JenisPrestasiPie02);

import JenisPrestasiPie03 from '~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiPie03.vue';
Vue.component('jenis-prestasi-pie-03', JenisPrestasiPie03);

//... Master Prestasi ...//

import MasterPrestasiAdminShow from '~/components/bantenprov/prestasi/master-prestasi/MasterPrestasiAdmin.show.vue';
Vue.component('master-prestasi-admin', MasterPrestasiAdminShow);

//... Echarts Master Prestasi ...//

import MasterPrestasi from '~/components/bantenprov/prestasi/master-prestasi/MasterPrestasi.chart.vue';
Vue.component('master-prestasi-echarts', MasterPrestasi);

import MasterPrestasiKota from '~/components/bantenprov/prestasi/master-prestasi/MasterPrestasiKota.chart.vue';
Vue.component('master-prestasi-echarts-kota', MasterPrestasiKota);

import MasterPrestasiTahun from '~/components/bantenprov/prestasi/master-prestasi/MasterPrestasiTahun.chart.vue';
Vue.component('master-prestasi-echarts-tahun', MasterPrestasiTahun);

//... Mini Bar Charts Master Prestasi ...//

import MasterPrestasiBar01 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiBar01.vue';
Vue.component('master-prestasi-bar-01', MasterPrestasiBar01);

import MasterPrestasiBar02 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiBar02.vue';
Vue.component('master-prestasi-bar-02', MasterPrestasiBar02);

import MasterPrestasiBar03 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiBar03.vue';
Vue.component('master-prestasi-bar-03', MasterPrestasiBar03);

//... Mini Pie Charts Master Prestasi ...//

import MasterPrestasiPie01 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiPie01.vue';
Vue.component('master-prestasi-pie-01', MasterPrestasiPie01);

import MasterPrestasiPie02 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiPie02.vue';
Vue.component('master-prestasi-pie-02', MasterPrestasiPie02);

import MasterPrestasiPie03 from '~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiPie03.vue';
Vue.component('master-prestasi-pie-03', MasterPrestasiPie03);

//... Prestasi ...//

import PrestasiAdminShow from '~/components/bantenprov/prestasi/prestasi/PrestasiAdmin.show.vue';
Vue.component('prestasi-admin', PrestasiAdminShow);

//... Echarts Prestasi ...//

import Prestasi from '~/components/bantenprov/prestasi/prestasi/Prestasi.chart.vue';
Vue.component('prestasi-echarts', Prestasi);

import PrestasiKota from '~/components/bantenprov/prestasi/prestasi/PrestasiKota.chart.vue';
Vue.component('prestasi-echarts-kota', PrestasiKota);

import PrestasiTahun from '~/components/bantenprov/prestasi/prestasi/PrestasiTahun.chart.vue';
Vue.component('prestasi-echarts-tahun', PrestasiTahun);

//... Mini Bar Charts Prestasi ...//

import PrestasiBar01 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiBar01.vue';
Vue.component('prestasi-bar-01', PrestasiBar01);

import PrestasiBar02 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiBar02.vue';
Vue.component('prestasi-bar-02', PrestasiBar02);

import PrestasiBar03 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiBar03.vue';
Vue.component('prestasi-bar-03', PrestasiBar03);

//... Mini Pie Charts Prestasi ...//

import PrestasiPie01 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiPie01.vue';
Vue.component('prestasi-pie-01', PrestasiPie01);

import PrestasiPie02 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiPie02.vue';
Vue.component('prestasi-pie-02', PrestasiPie02);

import PrestasiPie03 from '~/components/views/bantenprov/prestasi/prestasi/PrestasiPie03.vue';
Vue.component('prestasi-pie-03', PrestasiPie03);
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Jenis Prestasi
        {
            path: '/dashboard/jenis-prestasi',
            components: {
                main: resolve => require(['~/components/views/bantenprov/prestasi/jenis-prestasi/JenisPrestasiDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Jenis Prestasi"
            }
        },
        // Master Prestasi
        {
            path: '/dashboard/master-prestasi',
            components: {
                main: resolve => require(['~/components/views/bantenprov/prestasi/master-prestasi/MasterPrestasiDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master Prestasi"
            }
        },
        // Prestasi
        {
            path: '/dashboard/prestasi',
            components: {
                main: resolve => require(['~/components/views/bantenprov/prestasi/prestasi/PrestasiDashboard.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Prestasi"
            }
        },
        //...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Jenis Prestasi
        {
            path: '/admin/jenis-prestasi',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasi.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Jenis Prestasi"
            }
        },
        {
            path: '/admin/jenis-prestasi/create',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasi.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Jenis Prestasi"
            }
        },
        {
            path: '/admin/jenis-prestasi/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasi.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Jenis Prestasi"
            }
        },
        {
            path: '/admin/jenis-prestasi/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/jenis-prestasi/JenisPrestasi.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Jenis Prestasi"
            }
        },
        // Master Prestasi
        {
            path: '/admin/master-prestasi',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/master-prestasi/MasterPrestasi.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master Prestasi"
            }
        },
        {
            path: '/admin/master-prestasi/create',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/master-prestasi/MasterPrestasi.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Master Prestasi"
            }
        },
        {
            path: '/admin/master-prestasi/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/master-prestasi/MasterPrestasi.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Master Prestasi"
            }
        },
        {
            path: '/admin/master-prestasi/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/master-prestasi/MasterPrestasi.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Master Prestasi"
            }
        },
        // Prestasi
        {
            path: '/admin/prestasi',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/prestasi/Prestasi.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Prestasi"
            }
        },
        {
            path: '/admin/prestasi/create',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/prestasi/Prestasi.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Prestasi"
            }
        },
        {
            path: '/admin/prestasi/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/prestasi/Prestasi.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Prestasi"
            }
        },
        {
            path: '/admin/prestasi/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/prestasi/prestasi/Prestasi.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Prestasi"
            }
        },
        //...
    ]
},
```
