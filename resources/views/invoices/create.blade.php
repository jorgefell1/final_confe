<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Factura - Sistema de Facturación</title>
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
                        <li class="flex items-center gap-3 text-white bg-[#353a4a] rounded-lg px-3 py-2">
                            <i class='bx bx-receipt'></i>
                            <span x-show="sidebarOpen">Nueva Factura</span>
                        </li>
                    </ul>
                </div>

                <!-- Gestión -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-[#b0b3c7] uppercase tracking-wider mb-3" x-show="sidebarOpen">Gestión</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-3 text-[#b0b3c7] hover:text-white hover:bg-[#353a4a] rounded-lg px-3 py-2 cursor-pointer transition-all duration-200" onclick="window.location.href='{{ route('reports.index') }}'">
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
                <h1 class="text-4xl font-bold text-white mb-4">Nueva Factura Electrónica</h1>
                <p class="text-[#b0b3c7] text-lg">Crea y envía facturas electrónicas de manera rápida y segura</p>
            </div>

            <!-- Formulario de Factura -->
            <div class="bg-[#232733] rounded-2xl shadow-lg p-8">
                <form>
                    <!-- Información de la Empresa -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Información de la Empresa</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Empresa Emisora</label>
                                <select class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Seleccionar empresa...</option>
                                    <option>Empresa Ejemplo S.A.S</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Tipo de Documento</label>
                                <select class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Factura de Venta</option>
                                    <option>Nota Crédito</option>
                                    <option>Nota Débito</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Cliente -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Información del Cliente</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Tipo de Documento</label>
                                <select class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>NIT</option>
                                    <option>Cédula de Ciudadanía</option>
                                    <option>Cédula de Extranjería</option>
                                    <option>Pasaporte</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Número de Documento</label>
                                <input type="text" class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej: 900123456-1">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Razón Social / Nombre</label>
                                <input type="text" class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nombre del cliente">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#b0b3c7] mb-2">Email</label>
                                <input type="email" class="w-full px-3 py-2 bg-[#353a4a] border border-[#4b5163] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="cliente@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Productos/Servicios -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-white">Productos/Servicios</h2>
                            <button type="button" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all duration-200">
                                <i class='bx bx-plus'></i>
                                <span>Agregar Item</span>
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-[#353a4a]">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">Descripción</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">Cantidad</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">Valor Unit.</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">IVA</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-[#b0b3c7] uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <input type="text" class="w-full px-2 py-1 bg-[#353a4a] border border-[#4b5163] rounded text-white text-sm" placeholder="Descripción del producto/servicio">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" class="w-full px-2 py-1 bg-[#353a4a] border border-[#4b5163] rounded text-white text-sm" placeholder="1">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number" class="w-full px-2 py-1 bg-[#353a4a] border border-[#4b5163] rounded text-white text-sm" placeholder="0">
                                        </td>
                                        <td class="px-4 py-3">
                                            <select class="w-full px-2 py-1 bg-[#353a4a] border border-[#4b5163] rounded text-white text-sm">
                                                <option>0%</option>
                                                <option>5%</option>
                                                <option>19%</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-3 text-white text-sm">$0</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-red-400 hover:text-red-300">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totales -->
                    <div class="mb-8">
                        <div class="bg-[#353a4a] rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-right">
                                <div>
                                    <p class="text-[#b0b3c7] text-sm">Subtotal</p>
                                    <p class="text-white text-lg font-semibold">$0</p>
                                </div>
                                <div>
                                    <p class="text-[#b0b3c7] text-sm">IVA</p>
                                    <p class="text-white text-lg font-semibold">$0</p>
                                </div>
                                <div>
                                    <p class="text-[#b0b3c7] text-sm">Total</p>
                                    <p class="text-white text-2xl font-bold">$0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="px-6 py-3 bg-[#4b5163] text-white rounded-lg hover:bg-[#5a6175] transition-all duration-200">
                            Cancelar
                        </button>
                        <button type="button" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200">
                            Vista Previa
                        </button>
                        <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-200">
                            Generar Factura
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>