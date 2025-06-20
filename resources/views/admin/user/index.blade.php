@extends('admin.layoutAdmin')

<!-- Title page -->
@section('title', 'CRUD - Home User')

@section('content')
    <div class="pt-16">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete-button');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const form = this.closest('form');
                        const type = this.getAttribute('data-title');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: `You are about to delete "${type}"`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>

        <div class="w-full p-4 min-h-screen">

            <h1 class="text-center text-3xl font-semibold text-[var(--primary)] mt-2 mb-6 dark:text-white">User List</h1>

            <form action="{{ route('user.index') }}" method="GET" class="max-w-xl mx-auto mb-6 flex items-end space-x-3">
                <div class="flex-grow">
                    <label for="search" class="mb-2 text-sm font-medium text-primary sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search"
                            class="block w-full p-4 pl-10 text-sm text-primary border border-gray-300 rounded-lg bg-gray-50 focus:ring-[var(--accent-green)] focus:border-[var(--accent-green)]"
                            placeholder="Search by name" value="{{ request('search') }}">
                        <button type="submit"
                            class="bg-[var(--accent-blue)] text-white hover:bg-[var(--accent-green)] focus:ring-4 focus:ring-cyan-200 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 absolute right-2.5 bottom-2.5">
                            Search
                        </button>
                    </div>
                </div>

                <div class="w-48">
                    <label for="role_filter"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white sr-only">Filter by Role</label>
                    <select id="role_filter" name="role_filter"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[var(--accent-green)] focus:border-[var(--accent-green)] block w-full p-4">
                        <option value="">All Roles</option>
                        @foreach ($listRoles as $role)
                            <option value="{{ $role->id }}" {{ request('role_filter') == $role->id ? 'selected' : '' }}>
                                {{ $role->type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="px-4 py-2 bg-[var(--accent-blue)] text-white hover:bg-[var(--accent-green)] focus:ring-4 focus:ring-cyan-200 focus:outline-none font-medium rounded-lg text-sm h-full flex items-center justify-center">
                        Filter
                    </button>
                </div>
            </form>

            @if($message)
                @if($alertType === 'error')
                    <div id="alert-error" class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm.75 14.25a.75.75 0 0 1-1.5 0V11a.75.75 0 0 1 1.5 0Zm0-6a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="sr-only">Error</span>
                        <div class="ms-3 text-sm font-medium text-primary">
                            {{ $message }}
                        </div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex h-8 w-8 justify-center items-center"
                            data-dismiss-target="#alert-error" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 1l12 12M13 1 1 13" />
                            </svg>
                        </button>
                    </div>
                @elseif($alertType === 'info')
                    <div id="alert-info" class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm.75 14.25a.75.75 0 0 1-1.5 0V11a.75.75 0 0 1 1.5 0Zm0-6a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium text-primary">
                            {{ $message }}
                        </div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-100 inline-flex h-8 w-8 justify-center items-center"
                            data-dismiss-target="#alert-info" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 1l12 12M13 1 1 13" />
                            </svg>
                        </button>
                    </div>
                @endif
            @endif

            <div class="relative overflow-x-auto overflow-y-auto max-h-[80vh]">
                <table class="w-full text-sm text-left text-gray-500 bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-primary">No</th>
                            <th scope="col" class="px-6 py-3 text-primary">Name</th>
                            <th scope="col" class="px-6 py-3 text-primary">Email</th>
                            <th scope="col" class="px-6 py-3 text-primary">Phone</th>
                            <th scope="col" class="px-6 py-3 text-primary">Username</th>
                            <th scope="col" class="px-6 py-3 text-primary">Role</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="bg-white border-b hover:bg-gray-100">
                                <td class="px-6 py-4 text-primary whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-[var(--primary)] whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-[var(--primary)] whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-[var(--primary)] whitespace-nowrap">{{ $user->phone }}</td>
                                <td class="px-6 py-4 text-[var(--primary)] whitespace-nowrap">{{ $user->username }}</td>
                                <td class="px-6 py-4 text-[var(--primary)] whitespace-nowrap">{{ $user->role->type }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2 justify-end">
                                        <a href="{{ url('admin/user/detail/' . encrypt($user->id)) }}">
                                            <button type="button"
                                                class="bg-[var(--highlight)] text-white hover:bg-amber-400 focus:ring-4 focus:ring-amber-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                                Edit
                                            </button>
                                        </a>
                                        <form action="{{ route('user.delete', ['id' => encrypt($user->id)]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="button"
                                                class="delete-button text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5"
                                                data-title="{{ $user->name }}">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mb-4 mt-4 text-right">
                <a href="{{ url('/admin/user/form') }}">
                    <button
                        class="bg-[var(--accent-blue)] text-white hover:bg-[var(--accent-green)] focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        Add
                    </button>
                </a>
            </div>
        </div>

        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("success") }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <script>
            // Prevent showing old alerts when pressing back
            window.addEventListener('pageshow', function (event) {
                if (event.persisted || (window.performance && performance.navigation.type === 2)) {
                    window.location.reload();
                }
            });
        </script>

    </div>

@endsection