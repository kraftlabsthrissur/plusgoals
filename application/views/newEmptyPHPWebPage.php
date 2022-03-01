<div class="modal fade in" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="false" style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
            </div>
            <form action="#" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">TO:</span>
                            <input name="email_to" type="email" class="form-control" placeholder="Email TO">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">CC:</span>
                            <input name="email_to" type="email" class="form-control" placeholder="Email CC">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">BCC:</span>
                            <input name="email_to" type="email" class="form-control" placeholder="Email BCC">
                        </div>
                    </div>
                    <div class="form-group">
                        <ul class="wysihtml5-toolbar"><li class="dropdown">
                                <a class="btn btn-default dropdown-toggle " data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-font"></span>
                                    <span class="current-font">Normal text</span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="div" tabindex="-1" href="javascript:;" unselectable="on">Normal text</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" tabindex="-1" href="javascript:;" unselectable="on">Heading 1</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" tabindex="-1" href="javascript:;" unselectable="on">Heading 2</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3" tabindex="-1" href="javascript:;" unselectable="on">Heading 3</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4" tabindex="-1" href="javascript:;" unselectable="on">Heading 4</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h5" tabindex="-1" href="javascript:;" unselectable="on">Heading 5</a></li>
                                    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h6" tabindex="-1" href="javascript:;" unselectable="on">Heading 6</a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="btn-group">
                                    <a class="btn  btn-default" data-wysihtml5-command="bold" title="CTRL+B" tabindex="-1" href="javascript:;" unselectable="on">Bold</a>
                                    <a class="btn  btn-default" data-wysihtml5-command="italic" title="CTRL+I" tabindex="-1" href="javascript:;" unselectable="on">Italic</a>
                                    <a class="btn  btn-default" data-wysihtml5-command="underline" title="CTRL+U" tabindex="-1" href="javascript:;" unselectable="on">Underline</a>
                                </div>
                            </li>
                            <li>
                                <div class="btn-group">
                                    <a class="btn  btn-default" data-wysihtml5-command="insertUnorderedList" title="Unordered list" tabindex="-1" href="javascript:;" unselectable="on"><span class="glyphicon glyphicon-list"></span></a>
                                    <a class="btn  btn-default" data-wysihtml5-command="insertOrderedList" title="Ordered list" tabindex="-1" href="javascript:;" unselectable="on"><span class="glyphicon glyphicon-th-list"></span></a>
                                    <a class="btn  btn-default" data-wysihtml5-command="Outdent" title="Outdent" tabindex="-1" href="javascript:;" unselectable="on"><span class="glyphicon glyphicon-indent-right"></span></a>
                                    <a class="btn  btn-default" data-wysihtml5-command="Indent" title="Indent" tabindex="-1" href="javascript:;" unselectable="on"><span class="glyphicon glyphicon-indent-left"></span></a>
                                </div>
                            </li>
                            <li>
                                <div class="bootstrap-wysihtml5-insert-link-modal modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Insert link</h3>
                                            </div>
                                            <div class="modal-body">
                                                <input value="http://" class="bootstrap-wysihtml5-insert-link-url form-control">
                                                <label class="checkbox"> <input type="checkbox" class="bootstrap-wysihtml5-insert-link-target" checked="">Open link in new window</label>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                                <a href="#" class="btn btn-primary" data-dismiss="modal">Insert link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn  btn-default" data-wysihtml5-command="createLink" title="Insert link" tabindex="-1" href="javascript:;" unselectable="on">
                                    <span class="glyphicon glyphicon-share"></span>
                                </a>
                            </li>
                            <li>
                                <div class="bootstrap-wysihtml5-insert-image-modal modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Insert image</h3>
                                            </div>
                                            <div class="modal-body">
                                                <input value="http://" class="bootstrap-wysihtml5-insert-image-url form-control">
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                                <a class="btn btn-primary" data-dismiss="modal">Insert image</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn  btn-default" data-wysihtml5-command="insertImage" title="Insert image" tabindex="-1" href="javascript:;" unselectable="on">
                                    <span class="glyphicon glyphicon-picture"></span>
                                </a>
                            </li>
                        </ul><textarea name="message" id="email_message" class="form-control" style="height: 120px; display: none;" placeholder="Message"></textarea><input type="hidden" name="_wysihtml5_mode" value="1"><iframe class="wysihtml5-sandbox" security="restricted" allowtransparency="true" frameborder="0" width="0" height="0" marginwidth="0" marginheight="0" style="border-collapse: separate; border: 1px solid rgb(204, 204, 204); clear: none; display: block; float: none; margin: 0px; outline: rgb(85, 85, 85) none 0px; outline-offset: 0px; padding: 6px 12px; position: static; top: auto; left: auto; right: auto; bottom: auto; z-index: auto; vertical-align: baseline; text-align: start; box-sizing: border-box; -webkit-box-shadow: none; box-shadow: none; border-radius: 0px; width: 568px; height: 120px; background-color: rgb(255, 255, 255);"></iframe>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-success btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="attachment">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>

                </div>
                <div class="modal-footer clearfix">

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                    <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Send Message</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>