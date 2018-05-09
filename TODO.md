1. Pecah menu Prestasi menjadi du bagian, satu untuk admin sekolah satu lagi untuk administrator

-- Menu admin sekolah

```javascript
{
    name: 'Admin Sekolah',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
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
-- Menu administrator

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
        //...
    ]
},
```