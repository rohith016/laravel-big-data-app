<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('sales.create') }}">
                        {{ __('create sales') }}
                    </a>

                    <br>
                    <br>

                    <form action="{{ route('sales.index') }}" method="get">
                        <label for="">Search By Name :</label>
                        <input type="text" name="name" id="name" value="{{ request()-> name}}" />
                        <label for="">Search By Amount :</label>
                        <input type="text" name="amount" id="amount" value="{{ request()-> amount}}" />
                        <label for="">Search By Description :</label>
                        <input type="text" name="description" id="description" value="{{ request()-> description}}" />

                        <input type="submit" value="Search" />
                    </form>

                    <br>
                    <br>

                    <table class="table-auto w-full bg-white border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                    {{ __('SL NO.') }}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                    {{ __('Amount') }}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                    {{ __('Description') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesData as $sale)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ++$loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sale->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sale->amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sale->description }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- print pagination blade ui --}}

                    <br>
                    <br>

                    {{ $salesData->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
