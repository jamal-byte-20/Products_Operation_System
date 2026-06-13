<?php

use App\Models\Product;
use App\Models\User;

test('anyone can view products list', function () {
    $response = $this->get(route('products.index'));

    $response->assertStatus(200);
});

test('anyone can create a product', function () {
    $response = $this->post(route('products.store'), [
        'name' => 'Test Product',
        'description' => 'Test description',
        'price' => 99.99,
        'stock' => 10,
    ]);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'price' => 99.99,
        'stock' => 10,
    ]);
});

test('anyone can update a product', function () {
    $product = Product::create([
        'name' => 'Old Product',
        'price' => 10,
        'stock' => 5,
    ]);

    $response = $this->put(route('products.update', $product->id), [
        'name' => 'Updated ProductName',
        'price' => 15.50,
        'stock' => 20,
    ]);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated ProductName',
        'price' => 15.50,
        'stock' => 20,
    ]);
});

test('anyone can delete a product', function () {
    $product = Product::create([
        'name' => 'Delete Me',
        'price' => 10,
        'stock' => 5,
    ]);

    $response = $this->delete(route('products.destroy', $product->id));

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

test('guest is redirected to login from dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect(route('login'));
});

test('non-admin user is forbidden from dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(403);
});

test('admin user can access dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get('/dashboard');

    $response->assertStatus(200);
});
