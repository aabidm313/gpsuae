<x-app-layout>
    <x-slot name="header">
        <h5 class="mb-0">Dashboard</h5>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <p class="mb-0">Welcome, <strong>{{ Auth::user()->name }}</strong>. You are logged in.</p>
        </div>
    </div>
</x-app-layout>
