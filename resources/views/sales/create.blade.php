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

                    @if (\Session::has('error'))
                        <div class="alert alert-error">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-error">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif



                    <form method="post" action="{{route('sales.store')}}" enctype="multipart/form-data">
                        @csrf

                        <select name="type" id="type">
                            <option value="">Select Create Option</option>
                            <option value="file" @if(old("type") == "file") selected @endif>File Upload</option>
                            <option value="form" @if(old("type") == "form") selected @endif>Form Upload</option>
                        </select>

                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                        <input type="file" name="sales_csv"  id="sales_csv" />
                        <br>
                        <br>
                        <hr>
                        <br>
                        <br>
                        <label for="">Name:</label>
                        <input type="text" name="name" id="name" value="{{ old('name')}}" />
                        <br>
                        <br>
                        <label for="">Amount:</label>
                        <input type="text" name="amount" id="amount" value="{{ old('amount')}}" />
                        <br>
                        <br>
                        <label for="">Description:</label>
                        <input type="text" name="description" id="description" value="{{ old('description')}}" />
                        <br>
                        <br>
                        {{-- <input type="submit" class="button" value="upload"> --}}

                        <x-primary-button class="ms-3">
                            {{ __('Upload') }}
                        </x-primary-button>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
