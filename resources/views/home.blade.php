@extends('layouts.master')

@section('content')
    <div class="starter-template">
        <h1>Awesome 1th class url shorter</h1>
        <div class="row">
            <form class="shorter-form" >
                <div class="col-md-offset-2 col-md-4">
                    <input type="text" id="url" name="url" class="form-control" placeholder="link goes here" required >
                </div>
                <div class="col-md-3">
                    <input type="text" id="code"  name="code" class="form-control" placeholder="Do you prefer shortcode ?" >
                </div>
                <input class="btn btn-success" type="submit" value="shortMyUrl">
            </form>

        </div>


        <p class="lead">
            This url shortner will shorten your links.</p>
        <div class="row show_short_url hidden">

            <div class="col-md-offset-2 col-md-6 display">

            </div>


        </div>
    </div>


@endsection


@section('scripts')
    <script>

$(document).ready(function () {

    $('.shorter-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: base_url+'/shorten-url',
            data: { url: $('#url').val(), code: $('#code').val() }
        })
                .done(function( res ) {
                    if(res.status == true){
                        $('<input/>', {
                            type:"text",
                            class:'form-control'

                        }).val(res.short_url).appendTo(".show_short_url .display");
                        $('.show_short_url').removeClass('hidden')

                    }else{
                        alert(res.message[0])
                    }

                });

        return false;
    });
})
    </script>
@endsection

