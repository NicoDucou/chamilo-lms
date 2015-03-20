<script>
$(document).ready(function() {
    $.ajax({
        url:'{{ web_admin_ajax_url }}?a=version',
        success:function(version){
            $(".admin-block-version").html(version);
        }
    });

    $('a.edit-block').on('click', function(e) {
        e.preventDefault();

        var $self = $(this);

        var extraContent = $.ajax('{{ _p.web_ajax }}admin.ajax.php', {
            type: 'post',
            data: {
                a: 'get_extra_content',
                block: $self.data('id')
            }
        });

        $.when(extraContent).done(function(content) {
            $('#extra-content').val(content);
            $('#extra-block').val($self.data('id'));
            $('#modal-extra-title').text($self.data('label'));

            $('#modal-extra').modal('show');
        });
    });

    $('#btn-block-editor-save').on('click', function(e) {
        e.preventDefault();

        var save = $.ajax('{{ _p.web_ajax }}admin.ajax.php', {
            type: 'post',
            data: $('#block-extra-data').serialize() + '&a=save_block_extra'
        });

        $.when(save).done(function() {
            window.location.reload();
        });
    });
});
</script>

<section id="settings">
    {% for block_item in blocks %}
        {% if loop.index % 2 == 0 %}
        <div class="row">
        {% endif %}

        <div id="tabs-{{ loop.index }}" class="col-md-6">
            <div class="panel panel-default {{ block_item.class }}">
                <div class="panel-heading">
                    {{ block_item.icon }} {{ block_item.label }}
                    {% if block_item.editable and _u.is_admin %}
                        <a class="edit-block pull-right" href="#" data-label="{{ block_item.label }}" data-id="{{ block_item.class }}">
                            <img src="{{ _p.web_img }}icons/22/edit.png" alt="{{ 'Edit' | get_lang }}" title="{{ 'Edit' | get_lang }}">
                        </a>
                    {% endif %}
                </div>
                <div class="panel-body">
                <div style="display: block;">
                    {{ block_item.search_form }}
                </div>
                {% if block_item.items is not null %}
                    <div class="block-items-admin">
                    <ul class="list-items-admin">
    		    	{% for url in block_item.items %}
    		    		<li>
                            <a href="{{ url.url }}">
                                {{ url.label }}
                            </a>
                        </li>
    				{% endfor %}
                    </ul>
                    </div>
                {% endif %}

                {% if block_item.extra is not null %}
                    <div>
                    {{ block_item.extra }}
                    </div>
                {% endif %}

                {% if block_item.extraContent %}
                    <div>{{ block_item.extraContent }}</div>
                {% endif %}
            </div>
            </div>
        </div>

        {% if loop.index % 2 == 0 %}
            </div>
        {% endif %}
    {% endfor %}
</section>

{% if _u.is_admin %}
    <div class="modal fade" id="modal-extra">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ 'Close' | get_lang }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal-extra-title">{{ 'Blocks' | get_lang }}</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="block-extra-data">
                        <div class="form-group">
                            <textarea rows="15" name="content" class="form-control" id="extra-content"></textarea>
                            <input type="hidden" name="block" id="extra-block" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-block-editor-save" class="btn btn-primary">
                        <i class="fa fa-floppy-o"></i> {{ 'Save' | get_lang }}
                    </button>
                </div>
            </div>
        </div>
    </div>
{% endif %}
