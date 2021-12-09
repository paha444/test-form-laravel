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
    <?php
    $form = [];
    if(session('form')) $form = session('form');
    ?> 
    
        <form action="{{route('create_submit')}}" method="post" enctype="multipart/form-data">
        
        {{ csrf_field() }}
                   
                   
                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        ТТН
                        </label>
                        <div class="col-sm-12">
                          
                           <input type="text" class="form-control" name="TTN" id="ttn" value="<?php if(isset($form['TTN'])) echo $form['TTN'] ?>">
                           
                           <label><input type="checkbox" name="TTN_auto" <?php if(isset($form['TTN_auto'])) echo 'checked' ?>/> - Создать автоматически </label>
                        </div>
                     </div>
                     
                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        Статус
                        </label>
                        <div class="col-sm-12">
                          
                           <select name="Status" id="Status" required="required">
                                <option value="1" selected="selected">Подготовлена для отправки в ГПСС</option>
                                <option value="2">Отправлена в ГПСС</option>
                                <option value="3">Подготовлена к отправке</option>
                                <option value="4">Отправлена</option>
                           </select>
                           
                           
                        </div>
                     </div>


                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        Отправитель (ФИО, Наименование компании)
                        </label>
                        <div class="col-sm-12">
                          
                           <input type="text" class="form-control" name="Sender" id="Sender" value="<?php if(isset($form['Sender'])) echo $form['Sender'] ?>" required="required">
                           
                           
                        </div>
                     </div>


                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        Получатель (ФИО, Наименование компании)
                        </label>
                        <div class="col-sm-12">
                          
                           <input type="text" class="form-control" name="Recipient" id="Recipient" value="<?php if(isset($form['Recipient'])) echo $form['Recipient'] ?>" required="required">
                           
                           
                        </div>
                     </div>


                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        Город отправителя
                        </label>
                        <div class="col-sm-12" id="city_block">
                          
                           <input type="text" class="form-control" name="Sender_city" id="Sender_city" value="<?php if(isset($form['Sender_city'])) echo $form['Sender_city'] ?>" required="required">
                           
                           
                        </div>
                     </div>


                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        Город получателя
                        </label>
                        <div class="col-sm-12" id="city_block2">
                          
                           <input type="text" class="form-control" name="Recipient_city" id="Recipient_city" value="<?php if(isset($form['Recipient_city'])) echo $form['Recipient_city'] ?>" required="required">
                           
                           
                        </div>
                     </div>


                     <div class="row mb-3">
                        <label class="col-sm-12 control-label">
                        
                        </label>
                        <div class="col-sm-12">
                           
                           <button type="submit" class="btn btn-primary">Создать</button>
            
                           
                           
                        </div>
                     </div>
                     
                     
                     
                     
                     
       </form>                   
                   

  <script type="text/javascript">
  
    $('#Sender_city,#Recipient_city').keyup(function( event ) {
        
        var string = $(this).val();         
        var el_parent = $(this).parent(); 
        
          $.ajax({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

               url: '{{route("get_cities_front")}}',
               type: "POST",
               data: { 'string': string, '_token': $('meta[name="csrf-token"]').attr('content')},
               success: function(response){
                    
                    if(el_parent.find('.box').length > 0){
                        
                        el_parent.find('.box').html(response.data);
                        
                        el_parent.find('.box').fadeIn();
                        
                    }else{
                        
                        el_parent.append('<div class="box">'+response.data+'</div>');
                        
                    }
               }
          });
        
    });
    
    
      $('#city_block input,#city_block2 input').dblclick(function(){
            $(this).parent().find('.box').fadeIn();
      });
      
      $('#city_block, #city_block2').on('click', '.box a', function(e){
         $(this).parent().parent().parent().find('input').val($(this).text());
         $(this).parent().parent().fadeOut();
      });
        
      $('#city_block, #city_block2').on('mouseleave', '.box', function(e){  
        $(this).fadeOut();
      });
               
    
    
  
  </script>

                   
                   
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
