<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push("Dashboard", route('dashboard'));
});

// HO
Breadcrumbs::for('cabang', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('cabang', route('ho.cabang'));
});
Breadcrumbs::for('tujuan', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('cabang', route('ho.tujuan'));
});

Breadcrumbs::for('departemen', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('departemen', route('ho.departemen'));
});

// Formpst
Breadcrumbs::for('Form', function ($trail) {
    $trail->push('Form', route('formpst.form'));
});

Breadcrumbs::for('Show', function ($trail) {
    $trail->parent('Form');
    $trail->push('Show', route('formpst.show'));
});

