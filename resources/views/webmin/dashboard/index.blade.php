@extends('webmin.layouts.base')

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="card-box">
            <div class="row">
                <!-- <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-danger btn-block waves-effect m-t-20 waves-light">
                                <i class="fa fa-plus"></i> Create New
                            </a>
                            <div id="external-events" class="m-t-20">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>New Theme Release
                                </div>
                                <div class="external-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>My Event
                                </div>
                                <div class="external-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>Meet manager
                                </div>
                                <div class="external-event bg-purple" data-class="bg-purple">
                                    <i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>Create New theme
                                </div>
                            </div>
                            <div class="checkbox checkbox-custom m-t-40">
                                <input id="drop-remove" type="checkbox">
                                <label for="drop-remove">
                                    Remove after drop
                                </label>
                            </div>

                        </div>
                    </div>
                </div> -->
            </div> <!-- end row -->
        </div>

        <!-- BEGIN MODAL -->
        <div class="modal fade none-border" id="event-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Detail Info</h4>
                    </div>
                    <div class="modal-body">
                        <h4 id="modalTitle">Text in a modal</h4>
                        <p id="when">Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                        <hr>
                        <div id="modalDescription"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Modal Add Category -->
        <div class="modal fade none-border" id="add-category">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add a category</h4>
                    </div>
                    <div class="modal-body p-20">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Category Name</label>
                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Choose Category Color</label>
                                    <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                        <option value="success">Success</option>
                                        <option value="danger">Danger</option>
                                        <option value="info">Info</option>
                                        <option value="pink">Pink</option>
                                        <option value="primary">Primary</option>
                                        <option value="warning">Warning</option>
                                        <option value="orange">Orange</option>
                                        <option value="brown">Brown</option>
                                        <option value="teal">Teal</option>
                                        <option value="inverse">Inverse</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
    </div>
    <!-- end col-12 -->
</div> <!-- end row -->
@endsection

@section('css')
@endsection

@section('js')
@endsection

@section('javascript')
@endsection