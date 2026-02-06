<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TecnicoController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/**
 * ROTAS WEB - WEB.PHP
 * Define todas as rotas da aplicação web
 * Organizadas por funcionalidade: login, admin, técnico, cliente
 * Cada rota tem middleware de autenticação e permissões específicas
 */

// ==================== ROTAS PÚBLICAS (SEM AUTENTICAÇÃO) ====================
Route::get('/', [LoginController::class, 'index'])->name('home');

Route::get ('/login', [LoginController::class, "login"])->name('login');

Route::post('/login', [LoginController::class, "logar"])->name('logar');

Route::get('/logout', [LoginController::class, "logout"])->name('logout');

// ==================== ROTAS DO ADMINISTRADOR ====================
Route::get('/admin/homepage', [AdminController::class, 'homepage'])->name('adm.homepage')->middleware(['auth', 'role:adm']);

// Gerenciamento de usuários
Route::get('/admin/users', [AdminController::class, 'users'])->name('adm.users')->middleware(['auth', 'role:adm']);
Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('adm.users.create')->middleware(['auth', 'role:adm']);
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('adm.users.store')->middleware(['auth', 'role:adm']);
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('adm.users.edit')->middleware(['auth', 'role:adm']);
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('adm.users.update')->middleware(['auth', 'role:adm']);
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('adm.users.delete')->middleware(['auth', 'role:adm']);

// Gerenciamento de chamados
Route::get('/admin/tickets', [AdminController::class, 'tickets'])->name('adm.tickets')->middleware(['auth', 'role:adm']);
Route::get('/admin/tickets/{id}', [AdminController::class, 'showTicket'])->name('adm.ticket.show')->middleware(['auth', 'role:adm']);
Route::post('/admin/tickets/{id}/assign', [AdminController::class, 'assignTechnician'])->name('adm.ticket.assign')->middleware(['auth', 'role:adm']);
Route::post('/admin/tickets/{id}/status', [AdminController::class, 'updateTicketStatus'])->name('adm.ticket.status')->middleware(['auth', 'role:adm']);
// Nova rota: permite arquivar chamados finalizados para organização
Route::post('/admin/tickets/{id}/archive', [AdminController::class, 'archiveTicket'])->name('adm.ticket.archive')->middleware(['auth', 'role:adm']);
Route::delete('/admin/tickets/{id}', [AdminController::class, 'deleteTicket'])->name('adm.ticket.delete')->middleware(['auth', 'role:adm']);

// Relatórios e configurações
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('adm.reports')->middleware(['auth', 'role:adm']);
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('adm.settings')->middleware(['auth', 'role:adm']);

// ==================== ROTAS DO TÉCNICO ====================
Route::get('/tecnico/homepage', [TecnicoController::class, 'homepage'])->name('tecnico.homepage')->middleware(['auth', 'role:tecnico']);

Route::get('/tecnico/ticket/{id}', [TecnicoController::class, 'showTicket'])->name('tecnico.ticket.show')->middleware(['auth', 'role:tecnico']);

Route::post('/tecnico/ticket/{id}/assign', [TecnicoController::class, 'assignTicket'])->name('tecnico.ticket.assign')->middleware(['auth', 'role:tecnico']);

Route::post('/tecnico/ticket/{id}/status', [TecnicoController::class, 'updateTicketStatus'])->name('tecnico.ticket.status')->middleware(['auth', 'role:tecnico']);

Route::post('/tecnico/ticket/{id}/message', [TecnicoController::class, 'storeMessage'])->name('tecnico.message.store')->middleware(['auth', 'role:tecnico']);

// ==================== ROTAS DO CLIENTE ====================
Route::get('/cliente/homepage', [ClienteController::class, 'homepage'])->name('cliente.homepage')->middleware(['auth', 'role:cliente']);

Route::get('/cliente/ticket', [ClienteController::class, 'createTicket'])->name('cliente.ticket.create')->middleware(['auth', 'role:cliente']);

Route::post('/cliente/ticket', [ClienteController::class, 'storeTicket'])->name('cliente.ticket.store')->middleware(['auth', 'role:cliente']);

Route::get('/cliente/ticket/{id}', [ClienteController::class, 'showTicket'])->name('cliente.ticket.show')->middleware(['auth', 'role:cliente']);

Route::post('/cliente/ticket/{id}/message', [ClienteController::class, 'storeMessage'])->name('cliente.message.store')->middleware(['auth', 'role:cliente']);

