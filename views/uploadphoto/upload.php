    <div id="drag-and-drop-zone-{{size}}" class="uploader">
        <div class="crop"><a href="#" data-toggle="modal" data-target="#crop_desc">Кадрирование <i
                        class="fa fa-question-circle" aria-hidden="true"></i></a>
            <br>
            <label class="switch">
                <input type="checkbox" checked=""><span class="slider round"></span></label>
        </div>
        <span class="dnd-size" style="font-size:3rem;">{{size}}</span>
        <div style="color: #d7582d;">
            {{price}} руб. / шт.
        </div>
        <div class="dnd-drop">Перетащите сюда свои фотографии мышкой</div>
        <div class="or">ИЛИ</div>
        <div class="browser">
            <label><span><span class="fa fa-upload"></span>Нажмите, чтобы выбрать файлы</span>

                <input type="file" name="files[]" accept="image/png,image/jpeg" multiple="multiple"
                       title="Нажмите, чтобы выбрать файлы">
            </label>
            <div style="margin-top: 0.5rem; font-size: 0.8rem; color: #000;">К печати принимаются только форматы
                <b>JPG</b> и <b>PNG</b>.
                <br>Размеры изображения не должны превышать <b>5315x3543 px</b>.
                <br>Максимально допустимое разрешение <b>300 DPI</b>.
            </div>
        </div>
        <div style="height: 32px;"><img id="upload_progress" src="/img/uploadphoto/loading.gif"></div>
        <div class="uploader_counter" style="font-size: 1rem; margin-top: 0.5rem;"></div>
        <div class="mass_control"><a href="javascript:void(0);" class="button btn btn-primary allmate">Все матовые</a><a
                    href="javascript:void(0);" class="button btn btn-primary allglossy">Все глянцевые</a></div>
        <div id="fileList-{{size}}" class="filelist"></div>
    </div>