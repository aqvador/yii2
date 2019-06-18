<div class="file calculator" size="{{size}}" id="uploadFile{{size}}_{{count}}">
    <div class="info">
        <div class="preview_image">
            <input onclick="removeImage('uploadFile{{size}}_{{count}}')" type="button" title="Удалить изображение"
                   value="x" class="delete_img">
            <img src="/img/uploadphoto/loading2.gif"">
        </div>
        <div class="filename" title="{{title}}">{{title}}
        </div>
        <div>
            <input type="button" value="-" class="qtyminus" field="{{size}}_{{count}}"
            ><input class="qty success" type="text" name="{{size}}_{{count}}" value="1 шт." disabled=""
            ><input type="button" value="+" class="qtyplus red" field="{{size}}_{{count}}">
            <br>
            Тип бумаги:
            <select class="paper" name="paper">
                <option value="glossy" selected="">Глянцевая</option>
                <option value="mate">Матовая</option>
            </select></div>
        <span style="" class="status success fa fa-check"></span></div>
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75"
             aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
</div>