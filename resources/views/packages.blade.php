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
                <div class="alert alert-warning">
                    {!! session('error') !!}
                </div>
             @endif
        
        
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>ТТН</th>
                            <th>Статус</th>
                            <th>Отправитель (ФИО, Наименование компании)</th>
                            <th>Получатель (ФИО, Наименование компании)</th>
                            <th>Город отправителя</th>
                            <th>Город получателя</th>
                            <th>Дата создания</th>
                            <th></th>
                            <th></th>
                        </tr>
                    
                    
                    
                    @foreach($packages as $key=>$package)
                    
                    <tr>
                        <td>{{$package->id}}</td>
                        <td style="width: 20%;">{{$package->TTN}}</td>
                        <td>
                        <?php 
                        
switch ($package->Status) {
    case 0:
        echo "не указано";
        break;
    case 1:
        echo "Подготовлена для отправки в ГПСС";
        break;
    case 2:
        echo "Отправлена в ГПСС";
        break;
    case 3:
        echo "Подготовлена к отправке";
        break;
    case 4:
        echo "Отправлена";
        break;
}                        
                        
                        ?>
                        
                        </td>
                        <td>{{$package->Sender}}</td>
                        <td>{{$package->Recipient}}</td>
                        <td>{{$package->Sender_city}}</td>
                        <td>{{$package->Recipient_city}}</td>
                        <td>{{$package->created_at}}</td>
                        <td><a href="{{ route('edit',$package->id) }}"><button type="button" class="btn btn-secondary">Изменить</button></a></td>
                        <td><a href="{{ route('delete',$package->id) }}" onclick="return window.confirm('Вы действительно хотите удалить?');"><button type="button" class="btn btn-danger">Удалить</button></a></td>
                    </tr>
                    
                    @endforeach
                    
                    
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
