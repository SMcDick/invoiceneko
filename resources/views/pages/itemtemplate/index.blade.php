@extends("layouts/default")

@section("head")
    <title>{{ config('app.name') }}</title>
    <style>
        .card-panel.tab-panel {
            margin-top: 0;
        }
        .tab {
            background-color: #299a9a;
        }
        .tabs .tab a {
            color: #cbdede;
        }
        .tabs .tab a:hover, .tabs .tab a.active {
            color: #fff;
        }
        .tabs .indicator {
            height: 5px;
            background-color: #FFD264;
        }
        #itemtemplate-container {
            margin: 0px;
        }
    </style>
@stop

@section("content")
    <div class="wide-container">
        <div class="row">
            <div class="col s6">
                <h3>Item Templates</h3>
            </div>

            <div class="col s6 right mtop30">
                <a href="{{ route('itemtemplate.create') }}" class="btn btn-link waves-effect waves-dark">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel" style="padding: 2px;">
                    <input id="search-input" class="card-input" name="search-input" type="text" placeholder="Search">
                </div>

                <div id="itemtemplate-container" class="row">
                    <div class="card-panel flex">
                        <table id="itemtemplates-table" class="responsive-table striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($itemtemplates as $key => $itemtemplate)
                                    <tr class="single-itemtemplate-row">
                                        <td>{{ $itemtemplate->name  }}</td>
                                        <td>{{ $itemtemplate->quantity }}</td>
                                        <td>{{ $itemtemplate->price }}</td>
                                        <td>
                                            <a href="{{ route('itemtemplate.show', [ 'itemtemplate' => $itemtemplate->id ] ) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="View Item Template"><i class="material-icons">remove_red_eye</i></a>
                                            <form method="post" action="{{ route('itemtemplate.duplicate', [ 'itemtemplate' => $itemtemplate->id ] ) }}" class="null-form tooltipped" data-position="top" data-delay="50" data-tooltip="Duplicate Item Template">
                                                {{ csrf_field() }}
                                                <button class="null-btn" type="submit"><i class="material-icons">control_point_duplicate</i></button>
                                            </form>
                                            <a href="{{ route('itemtemplate.edit', [ 'itemtemplate' => $itemtemplate->id ] ) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Edit Item Template"><i class="material-icons">mode_edit</i></a>
                                            <a href="#" data-id="{{ $itemtemplate->id }}" class="itemtemplate-delete-btn tooltipped" data-position="top" data-delay="50" data-tooltip="Delete Item Template"><i class="material-icons">delete</i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-confirmation" class="modal">
        <div class="modal-content">
            <p>Delete Item Template?</p>
        </div>
        <div class="modal-footer">
            <form id="delete-itemtemplate-form" method="post" class="null-form">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="modal-action waves-effect black-text waves-green btn-flat btn-deletemodal itemtemplate-confirm-delete-btn" type="submit">Delete</button>
            </form>
            <a href="javascript:;" class=" modal-action modal-close waves-effect black-text waves-red btn-flat btn-deletemodal">Cancel</a>
        </div>
    </div>
@stop

@section("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.0/jquery.mark.min.js" integrity="sha256-1iYR6/Bs+CrdUVeCpCmb4JcYVWvvCUEgpSU7HS5xhsY=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        "use strict";
        $(function() {
            $('.modal').modal();

            $('#itemtemplate-container').on('click', '.itemtemplate-delete-btn', function (event) {
                event.preventDefault();
                let itemtemplateid = $(this).attr('data-id');
                $('#delete-itemtemplate-form').attr('action', '/itemtemplate/' + itemtemplateid + '/destroy');
                $('#delete-confirmation').modal('open');
            });

            let inputBox = $('#search-input');
            let context = $('#itemtemplate-container .single-itemtemplate-row');

            inputBox.on("input", function() {
                let term = $(this).val();
                context.unmark().show();
                if (term != "") {
                    console.log(term);
                    context.mark(term, {
                        done: function() {
                            context.not(":has(mark)").hide();
                        }
                    });
                }
            });
        });
    </script>
@stop