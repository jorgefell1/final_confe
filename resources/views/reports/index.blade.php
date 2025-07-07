<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Sistema de Facturación</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .fade-in {
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#181c24]">
    <div x-data="{ sidebarOpen: true, userMenuOpen: false }" class="flex min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
               class="bg-[#232733] text-white flex flex-col py-8 px-4 min-h-screen transition-all duration-300">

            <!-- Botón Toggle -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="mb-6 p-2 bg-[#353a4a] rounded hover:bg-[#4b5163] transition">
                <i class='bx bx-menu text-2xl'></i>
            </button>

            <!-- Logo o Título -->
            <div class="flex items-center mb-10" x-show="sidebarOpen">
                <span class="text-2xl font-bold tracking-widest">FACTURACIÓN</span>
            </div>

            <!-- Perfil -->
            <div class="flex items-center gap-3 mb-8 relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <i class='bx bx-user text-white text-xl'></i>
                </div>
                <div @click="userMenuOpen = !userMenuOpen" class="cursor-pointer" x-show="sidebarOpen">
                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-[#b0b3c7]">Administrador</div>
                </div>

                <!-- Dropdown -->
                <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                     class="absolute top-14 left-0 bg-[#353a4a] rounded shadow-lg w-48 z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm hover:bg-[#4b5163]">Editar Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-[#4b5163] text-red-400">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="flex-1">
                <!-- Principal -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-[#b0b3c7] uppercase tracking-wider mb-3" x-show="sidebarOpen">Principal</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-3 text-[#b0b3c7] hover:text-white hover:bg-[#353a4a] rounded-lg px-3 py-2 cursor-pointer transition-all duration-200" onclick="window.location.href='{{ route('dashboard') }}'">
                            <i class='bx bx-grid-alt'></i>
                            <span x-show="sidebarOpen">Dashboard</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#b0b3c7] hover:text-white hover:bg-[#353a4a] rounded-lg px-3 py-2 cursor-pointer transition-all duration-200" onclick="window.location.href='{{ route('companies.index') }}'">
                            <i class='bx bx-buildings'></i>
                            <span x-show="sidebarOpen">Compañías</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#b0b3c7] hover:text-white hover:bg-[#353a4a] rounded-lg px-3 py-2 cursor-pointer transition-all duration-200" onclick="window.location.href='{{ route('invoices.create') }}'">
                            <i class='bx bx-receipt'></i>
                            <span x-show="sidebarOpen">Nueva Factura</span>
                        </li>
                    </ul>
                </div>

                <!-- Gestión -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-[#b0b3c7] uppercase tracking-wider mb-3" x-show="sidebarOpen">Gestión</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-3 text-white bg-[#353a4a] rounded-lg px-3 py-2">
                            <i class='bx bx-bar-chart-alt-2'></i>
                            <span x-show="sidebarOpen">Reportes</span>
                        </li>
                        <li class="flex items-center gap-3 text-[#b0b3c7] hover:text-white hover:bg-[#353a4a] rounded-lg px-3 py-2 cursor-pointer transition-all duration-200" onclick="window.location.href='{{ route('users.index') }}'">
                            <i class='bx bx-user-plus'></i>
                            <span x-show="sidebarOpen">Usuarios</span>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Logout -->
            <div class="mt-auto pt-4 border-t border-[#353a4a]">
                <div class="flex items-center gap-3 text-[#b0b3c7] hover:text-red-400 cursor-pointer px-3 py-2 rounded-lg hover:bg-[#353a4a] transition-all duration-200">
                    <i class='bx bx-log-out'></i>
                    <span x-show="sidebarOpen">Cerrar Sesión</span>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'flex-1 p-10 fade-in ml-0' : 'flex-1 p-10 fade-in ml-0'" class="transition-all duration-300">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white mb-4">Reportes y Estadísticas</h1>
                <p class="text-[#b0b3c7] text-lg">Visualiza el rendimiento y estadísticas del sistema</p>
            </div>

            <!-- Filtros -->
            <div class="bg-[#232733] rounded-2xl shadow-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-white mb-4">Filtros de Reporte</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Fecha Desde</label>
                        <input type="date" class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Fecha Hasta</label>
                        <input type="date" class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Empresa</label>
                        <select class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option>Todas las empresas</option>
                            <option>Empresa Ejemplo S.A.S</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-all duration-200">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Generales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#b0b3c7] text-sm">Facturas Emitidas</p>
                            <p class="text-white text-2xl font-bold">0</p>
                            <p class="text-green-400 text-sm">+0% vs mes anterior</p>
                        </div>
                        <div class="bg-green-500 p-3 rounded-lg">
                            <i class='bx bx-receipt text-2xl text-white'></i>
                        </div>
                    </div>
                </div>

                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#b0b3c7] text-sm">Ingresos Totales</p>
                            <p class="text-white text-2xl font-bold">$0</p>
                            <p class="text-green-400 text-sm">+0% vs mes anterior</p>
                        </div>
                        <div class="bg-blue-500 p-3 rounded-lg">
                            <i class='bx bx-dollar text-2xl text-white'></i>
                        </div>
                    </div>
                </div>

                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#b0b3c7] text-sm">Clientes Activos</p>
                            <p class="text-white text-2xl font-bold">0</p>
                            <p class="text-green-400 text-sm">+0% vs mes anterior</p>
                        </div>
                        <div class="bg-orange-500 p-3 rounded-lg">
                            <i class='bx bx-user text-2xl text-white'></i>
                        </div>
                    </div>
                </div>

                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#b0b3c7] text-sm">Promedio Factura</p>
                            <p class="text-white text-2xl font-bold">$0</p>
                            <p class="text-green-400 text-sm">+0% vs mes anterior</p>
                        </div>
                        <div class="bg-purple-500 p-3 rounded-lg">
                            <i class='bx bx-trending-up text-2xl text-white'></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Gráfico de Ventas -->
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Ventas por Mes</h3>
                    <div class="h-64 flex items-center justify-center text-[#b0b3c7]">
                        <div class="text-center">
                            <i class='bx bx-bar-chart-alt-2 text-4xl mb-2'></i>
                            <p>Gráfico de ventas</p>
                            <p class="text-sm">No hay datos suficientes</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Productos -->
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Productos Más Vendidos</h3>
                    <div class="h-64 flex items-center justify-center text-[#b0b3c7]">
                        <div class="text-center">
                            <i class='bx bx-pie-chart-alt-2 text-4xl mb-2'></i>
                            <p>Gráfico de productos</p>
                            <p class="text-sm">No hay datos suficientes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Facturas Recientes -->
            <div class="bg-[#232733] rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-[#353a4a]">
                    <h2 class="text-xl font-bold text-white">Facturas Recientes</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#353a4a]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#b0b3c7] uppercase tracking-wider">Número</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#b0b3c7] uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#b0b3c7] uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#b0b3c7] uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-[#b0b3c7] uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#353a4a]">
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-[#b0b3c7]">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-receipt text-4xl mb-2'></i>
                                        <p>No hay facturas registradas</p>
                                        <p class="text-sm">Crea tu primera factura para ver reportes</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>