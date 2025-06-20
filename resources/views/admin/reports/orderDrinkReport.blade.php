@extends('admin.layoutAdmin')

@section('title', 'CRUD - Report Order Drink')
@section('content')

<div class="pt-16">
    <div class="w-full p-4 min-h-screen">
        <h1 class="text-center text-3xl font-semibold text-[var(--primary)] mt-2 mb-6 dark:text-white">Drink Orders Report</h1>

        <form action="{{ route('report.orderDrink') }}" method="GET" class="max-w-4xl mx-auto mb-5" id="filterForm">
            <div class="flex flex-wrap gap-4 items-center justify-start md:justify-center">
                <!-- filterr -->
                <div class="flex relative flex-wrap md:flex-row md:gap-2 bg-gray-50 text-sm text-primary border border-gray-300 rounded-lg focus:ring-[var(--accent-green)] focus:border-[var(--accent-green)]
                            md:justify-center md:items-center h-full shadow-md">

                    <div class="flex flex-col w-full sm:w-[48%] md:w-auto pl-2 pr-2 md:pr-4 border-b md:border-b-0 md:border-r border-gray-300">
                        <label for="start_date" class="my-1 text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            class="block pb-3 px-3 text-sm text-primary bg-gray-50 focus:ring-[var(--accent-green)] focus:border-[var(--accent-green)]"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="flex flex-col w-full sm:w-[48%] md:w-auto pl-4 pr-2">
                        <label for="end_date" class="my-1 text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            class="block pb-3 px-3 text-sm text-primary bg-gray-50 focus:ring-[var(--accent-green)] focus:border-[var(--accent-green)]"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="px-3 w-full md:w-auto flex justify-end sm:justify-center py-2">
                        <button type="submit"
                            class="w-18 h-10 bg-[var(--accent-blue)] text-white hover:bg-[var(--accent-green)] focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-4 py-2">
                            Filter
                        </button>
                    </div>
                </div>

                <button type="button" id="resetBtn"
                    class="text-white bg-amber-400 hover:bg-amber-500 focus:ring-4 focus:ring-amber-400 font-medium rounded-lg text-sm px-4 py-2 shadow-md">
                    Reset
                </button>
            </div>
        </form>

        <!-- tabel order -->
        <div class="relative overflow-x-auto overflow-y-scroll max-h-[80vh] rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-gray-500 bg-white border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-primary">No</th>
                        <th class="px-6 py-3 text-primary">Order Date</th>
                        <th class="px-6 py-3 text-primary">Customer Name</th>
                        <th class="px-6 py-3 text-primary">Drink Ordered</th>
                        <th class="px-6 py-3 text-primary">Quantity</th>
                        <th class="px-6 py-3 text-primary">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-sm md:text-md">
                    @php $grandTotal = 0; @endphp
                    @foreach ($orders as $order)
                    @php
                    $orderTotal = $order->orderDetails->sum('subtotal');
                    $grandTotal += $orderTotal;
                    @endphp

                    @foreach ($order->orderDetails as $index => $detail)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="px-6 py-3 text-primary">{{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-primary">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-3 text-primary">{{ $order->reservation->user->name }}</td>
                        <td class="px-6 py-3 text-primary">{{ $detail->beverage->name }}</td>
                        <td class="px-6 py-3 text-primary">{{ $detail->quantity }}</td>
                        <td class="px-6 py-3 text-primary">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <!-- Total per order buat batesin-->
                    <tr class="bg-gray-100 border-b">
                        <td colspan="5" class="px-6 py-2 text-right font-semibold text-primary">Total Order #{{ $loop->iteration }}</td>
                        <td class="px-6 py-2 font-semibold text-primary">Rp{{ number_format($orderTotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            <div class="text-xl font-semibold text-primary dark:text-white">
                Grand Total: Rp{{ number_format($grandTotal, 0, ',', '.') }}
            </div>
        </div>

        <div class="mb-4 mt-4 text-right">
            <a href="{{ route('report.orderDrinkPDF', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">
                <button
                    class="bg-rose-600 hover:bg-rose-500 text-white focus:ring-4 focus:ring-rose-200 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md">
                    Export to PDF
                </button>
            </a>
        </div>
    </div>
</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif

<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate && endDate && startDate >= endDate) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Start Date must be before End Date!',
            });
        }
    });

    document.getElementById('resetBtn').addEventListener('click', function() {
        window.location.href = "{{ route('report.orderDrink') }}";
    });
</script>

@endsection