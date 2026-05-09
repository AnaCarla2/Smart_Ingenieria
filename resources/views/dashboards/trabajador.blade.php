<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard — Trabajador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500 text-sm">Mis Asistencias este mes</p>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ auth()->user()->empleado?->asistencias()->whereMonth('fecha', now()->month)->count() ?? 0 }}
                    </p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500 text-sm">Proyectos Asignados</p>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ auth()->user()->empleado?->asignaciones()->distinct('proyecto_id')->count() ?? 0 }}
                    </p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Bienvenido, {{ auth()->user()->name }}</h3>
                <p class="text-gray-600">Desde aquí puedes ver tus asignaciones del día.</p>
            </div>
        </div>
    </div>
</x-app-layout>