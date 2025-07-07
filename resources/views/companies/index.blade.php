<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Empresas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div x-data="{ sidebarOpen: true, userMenuOpen: false, open: false, editOpen: false, editingCompany: {}, deleteOpen: false, companyToDelete: null, viewOpen: false, viewingCompany: {} }" class="flex min-h-screen">
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
                        <li class="flex items-center gap-3 text-white bg-[#353a4a] rounded-lg px-3 py-2">
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
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <h1 class="text-3xl font-bold text-white">Compañias</h1>
                </div>
                <button @click="open = true" class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600 transition flex items-center"><i class='bx bx-plus mr-2'></i> Registrar Empresa</button>
            </div>
            
            <!-- Formulario de búsqueda -->
            <div class="mb-6">
                <form action="{{ route('companies.index') }}" method="GET" class="flex items-center space-x-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" placeholder="Buscar por razón social..."
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#232733] text-[#b0b3c7] border border-[#353a4a] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200"
                               value="{{ $search ?? '' }}">
                        <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-[#b0b3c7]'></i>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-600 transition">Buscar</button>
                    @if ($search)
                        <a href="{{ route('companies.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-gray-600 transition">Limpiar</a>
                    @endif
                </form>
            </div>

            @if (session('status') && session('message'))
                @php
                    $alertClass = '';
                    $iconClass = '';
                    switch(session('status')) {
                        case 'created':
                            $alertClass = 'bg-green-500 border-green-600';
                            $iconClass = 'bx-check-circle';
                            break;
                        case 'updated':
                            $alertClass = 'bg-yellow-500 border-yellow-600';
                            $iconClass = 'bx-edit';
                            break;
                        case 'deleted':
                            $alertClass = 'bg-red-500 border-red-600';
                            $iconClass = 'bx-trash';
                            break;
                        case 'error':
                            $alertClass = 'bg-red-500 border-red-600';
                            $iconClass = 'bx-error';
                            break;
                        default:
                            $alertClass = 'bg-blue-500 border-blue-600';
                            $iconClass = 'bx-info-circle';
                    }
                @endphp
                <div class="{{ $alertClass }} text-white p-4 rounded-lg mb-6 border-l-4 shadow-lg fade-in">
                    <div class="flex items-center">
                        <i class='bx {{ $iconClass }} text-xl mr-3'></i>
                        <span class="font-medium">{{ session('message') }}</span>
                    </div>
                </div>
            @endif
            <div class="bg-[#232733] rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-white mb-6">Listado de Empresas</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-[#b0b3c7]">
                        <thead class="bg-[#232733] border-b border-[#353a4a]">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold uppercase">ID</th>
                                <th class="px-6 py-3 text-xs font-bold uppercase">Logo</th>
                                <th class="px-6 py-3 text-xs font-bold uppercase">Razón Social</th>
                                <th class="px-6 py-3 text-xs font-bold uppercase">RUC</th>
                                <th class="px-6 py-3 text-xs font-bold uppercase">Dirección</th>
                                <th class="px-6 py-3 text-xs font-bold uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                            <tr class="border-b border-[#353a4a] hover:bg-[#20232b] transition">
                                <td class="px-6 py-4 font-mono text-sm text-[#b0b3c7]">{{ $company['id'] }}</td>
                                <td class="px-6 py-4">
                                    @if ($company['logo_path'] && $company['logo_path'] !== '-')
                                        <img src="{{ asset('storage/' . $company['logo_path']) }}" alt="Logo" class="w-10 h-10 rounded-full object-cover border border-[#353a4a] bg-[#353a4a]">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($company['razon_social'] ?? 'Empresa') }}&background=353a4a&color=fff&size=48" alt="Logo" class="w-10 h-10 rounded-full border border-[#353a4a] bg-[#353a4a]">
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $company['razon_social'] ?? 'Sin razón' }}</td>
                                <td class="px-6 py-4">{{ $company['ruc'] ?? 'Sin RUC' }}</td>
                                <td class="px-6 py-4">{{ $company['direccion'] ?? 'Sin dirección' }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button @click="viewOpen = true; viewingCompany = {{ json_encode($company) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 flex items-center transition"><i class='bx bx-show'></i> Ver</button>
                                    <button @click="editOpen = true; editingCompany = {{ json_encode($company) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 flex items-center transition"><i class='bx bx-edit'></i> Editar</button>
                                    <button @click="deleteOpen = true; companyToDelete = {{ $company['id'] }}" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 flex items-center transition"><i class='bx bx-trash'></i> Eliminar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-4">
                    {{ $companies->links() }}
                </div>
            </div>
            <!-- Modal para registrar empresa -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 fade-in" style="display: none;">
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
                    <button @click="open = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                    <h2 class="text-2xl font-bold mb-4 text-white">Registrar Empresa</h2>
                    
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('companies.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Primera fila: Razón Social y RUC -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Razón Social *</label>
                                <input name="razon_social" type="text" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">RUC *</label>
                                <input name="ruc" type="text" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                        </div>

                        <!-- Segunda fila: Dirección -->
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Dirección *</label>
                                <input name="direccion" type="text" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                        </div>

                        <!-- Tercera fila: Logo de la Empresa y Certificado -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Logo de la Empresa</label>
                                <input name="logo" type="file" accept="image/*" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] rounded px-3 py-2 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                <small class="text-[#b0b3c7] text-xs mt-1 block">Imagen (JPG, PNG, GIF, SVG - máx 2MB)</small>
                            </div>
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Certificado (.pem) *</label>
                                <input name="certificado" type="file" accept=".pem" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] rounded px-3 py-2 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700" required>
                                <small class="text-[#b0b3c7] text-xs mt-1 block">Archivo .pem (máx 2MB)</small>
                            </div>
                        </div>

                        <!-- Última fila: Ambiente de Producción -->
                        <div class="mb-4 flex items-center justify-center">
                            <input name="production" type="checkbox" value="1" class="mr-2 w-4 h-4 text-green-600 bg-[#181c24] border-[#353a4a] rounded focus:ring-green-500">
                            <label class="text-[#b0b3c7]">¿Ambiente de Producción?</label>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal para editar empresa -->
            <div x-show="editOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 fade-in" style="display: none;">
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
                    <button @click="editOpen = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                    <h2 class="text-2xl font-bold mb-4 text-white">Editar Empresa</h2>
                    
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" x-bind:action="'{{ url('companies') }}/' + editingCompany.id" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Primera fila: Razón Social y RUC -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Razón Social *</label>
                                <input name="razon_social" type="text" x-bind:value="editingCompany.razon_social" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">RUC *</label>
                                <input name="ruc" type="text" x-bind:value="editingCompany.ruc" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                        </div>

                        <!-- Segunda fila: Dirección -->
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Dirección *</label>
                                <input name="direccion" type="text" x-bind:value="editingCompany.direccion" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] focus:bg-white focus:text-[#181c24] rounded px-3 py-2 transition-colors duration-200" required>
                            </div>
                        </div>

                        <!-- Tercera fila: Logo de la Empresa y Certificado -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Logo de la Empresa</label>
                                <input name="logo" type="file" accept="image/*" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] rounded px-3 py-2 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                <small class="text-[#b0b3c7] text-xs mt-1 block">Imagen (JPG, PNG, GIF, SVG - máx 2MB). Dejar vacío para no cambiar.</small>
                            </div>
                            <div class="mb-4">
                                <label class="block text-[#b0b3c7] mb-2">Certificado (.pem)</label>
                                <input name="certificado" type="file" accept=".pem" class="w-full border border-[#353a4a] bg-[#181c24] text-[#b0b3c7] rounded px-3 py-2 transition-colors duration-200 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700">
                                <small class="text-[#b0b3c7] text-xs mt-1 block">Archivo .pem (máx 2MB). Dejar vacío para no cambiar.</small>
                            </div>
                        </div>

                        <!-- Última fila: Ambiente de Producción -->
                        <div class="mb-4 flex items-center justify-center">
                            <input name="production" type="checkbox" value="1" x-bind:checked="editingCompany.production == 1" class="mr-2 w-4 h-4 text-green-600 bg-[#181c24] border-[#353a4a] rounded focus:ring-green-500">
                            <label class="text-[#b0b3c7]">¿Ambiente de Producción?</label>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal para eliminar empresa -->
            <div x-show="deleteOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 fade-in" style="display: none;">
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6 w-full max-w-md">
                    <button @click="deleteOpen = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                    <h2 class="text-2xl font-bold mb-4 text-white">Eliminar Empresa</h2>
                    <p class="text-[#b0b3c7] mb-4">¿Estás seguro de que deseas eliminar la empresa <span class="font-semibold" x-text="viewingCompany.razon_social"></span>? Esta acción no se puede deshacer.</p>
                    <div class="flex justify-end">
                        <form method="POST" x-bind:action="'{{ url('companies') }}/' + companyToDelete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Eliminar</button>
                        </form>
                        <button @click="deleteOpen = false" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Cancelar</button>
                    </div>
                </div>
            </div>
            <!-- Modal para ver empresa -->
            <div x-show="viewOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 fade-in" style="display: none;">
                <div class="bg-[#232733] rounded-2xl shadow-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
                    <button @click="viewOpen = false; viewingCompany = {}" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                    <h2 class="text-2xl font-bold mb-4 text-white">Detalles de la Empresa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">ID:</label>
                            <p class="text-[#b0b3c7] text-lg" x-text="viewingCompany.id"></p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">Razón Social:</label>
                            <p class="text-[#b0b3c7] text-lg" x-text="viewingCompany.razon_social"></p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">RUC:</label>
                            <p class="text-[#b0b3c7] text-lg" x-text="viewingCompany.ruc"></p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">Dirección:</label>
                            <p class="text-[#b0b3c7] text-lg" x-text="viewingCompany.direccion"></p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">Certificado (.pem):</label>
                            <p class="text-[#b0b3c7] text-lg">
                                <a :href="viewingCompany.certificado_path ? '{{ asset('storage/') }}/' + viewingCompany.certificado_path : '#'" target="_blank" class="text-blue-500 hover:underline" x-text="viewingCompany.certificado_path ? 'Ver certificado' : 'Sin certificado'"></a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">Ambiente de Producción:</label>
                            <p class="text-[#b0b3c7] text-lg" x-text="viewingCompany.production ? 'Sí' : 'No'"></p>
                        </div>
                        <div>
                            <label class="block text-[#b0b3c7] mb-2 text-xl font-semibold">Logo:</label>
                            <div class="flex items-center">
                                <img :src="viewingCompany.logo_path ? '{{ asset('storage/') }}/' + viewingCompany.logo_path : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(viewingCompany.razon_social || 'Empresa') + '&background=353a4a&color=fff&size=80'" alt="Logo" class="w-20 h-20 rounded-full object-cover border border-[#353a4a] bg-[#353a4a]">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button @click="viewOpen = false; viewingCompany = {}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Cerrar</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>