<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        
            @if (session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
            @elseif (session('error'))
                <div class="alert alert-error">
                    {!! session('error') !!}
                </div>
             @endif        
        
        
        
        
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
    <?php
    $form = [];
    if(session('form')) $form = session('form');
    ?> 
    
        <form action="{{route('load_xlsx_submit')}}" method="post" enctype="multipart/form-data">
        
        {{ csrf_field() }}
                   
                   
                    <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                            Выберите файл для загрузки посылок
                        </label>
                        <div class="col-sm-12">
                          
                           <input type="file" name="file" accept=".xlsx" required="required"/>
                           
                           
                        </div>
                     </div>

                     <div class="row mb-3">
                        <div class="col-sm-12">
                          
                           
                           <a href="{{asset('upload')}}/20474c1c0421724b6ab0_08_12_2021.xlsx" target="_blank" download><button type="button" class="btn btn-outline-primary">Скачать пример файла</button></a>
                           
                           
                        </div>
                     </div>

                     
                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        
                        </label>
                        <div class="col-sm-12">
                          
                           
                           <button type="submit" class="btn btn-primary">Загрузить</button>
                           
                           
                        </div>
                     </div>
                     
                     
                     
                     
                     
       </form>                   
                   
                   
                   
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
