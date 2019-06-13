    <div class="g-grid">
        <div class="g-block size-100">
            <div class="g-system-messages">
                <div id="system-message-container"></div>
            </div>
        </div>
    </div>
    <div class="g-grid">
        <div class="g-block size-100">
            <div class="g-content">
                <div class="platform-content">
                    <div class="moduletable ">
                        <script type="text/javascript">

                        </script>
                        <h3 id="photoprint_order" data-mid="116" onclick="showPhotoprintForm();"
                            class="button_glow"><span class="fa fa-print"></span> Приступить к
                            оформлению заказа</h3>
                        <div id="loading"><img
                                    src="/img/uploadphoto/loading.gif"/>
                        </div>
                        <div class="order_form">
                            <h3 style="color: #0086c0; margin-bottom: 0;">Номер заказа: <span
                                        id="order_num"></span></h3>
                            <h3 style="color: #0086c0;">К оплате: <span style="color: #d7582d;"
                                                                        id="order_price"></span></h3>
                            <div id="extended_products"
                                 onclick="jQuery('#recomended_products').modal();"></div>
                            <input id="form_name" required type="text"
                                   placeholder="Имя и Фамилия*"/>
                            <input id="form_email" required type="text" placeholder="Email*"/>
                            <input id="form_phone" required type="text" placeholder="Телефон*"/>
                            <textarea id="order_comment"
                                      placeholder="Комментарий к заказу"></textarea>
                            <input onclick="confirmOrder();" type="button"
                                   value="Подтвердить заказ"/>
                            <br/>
                            <input class="cancel_order" onclick="hideOrderForm();" type="button"
                                   value="Назад"/>
                        </div>
                        <div id="photoprint_form">
                            <div id="sizes">
                                <div
                                        style="border: 1px solid #0086c0; text-align: center; font-weight: bold; color: #0086c0; padding: 0.5rem;">
                                    Выберите размер:
                                </div>
                                <a href="javascript:void(0);">9x13</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a class="chosen" href="javascript:void(0);">10x15</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">11x15</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">13x18</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">15x15</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">15x20</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">20x20</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">20x30</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <a href="javascript:void(0);">21x30</a>
                                <div class="size_cnt" title="Количество загруженных фотографий">0
                                </div>
                                <div class="large_sizes">
                                    <a href="javascript:void(0);">20x40</a>
                                    <div class="size_cnt" title="Количество загруженных фотографий">
                                        0
                                    </div>
                                    <a href="javascript:void(0);">30x42</a>
                                    <div class="size_cnt" title="Количество загруженных фотографий">
                                        0
                                    </div>
                                </div>
                            </div>
                            <div id="upload_block">
                                <div class="large_uploaders"></div>
                            </div>
                            <hr style="clear: both; margin-top: 0; padding-top: 1.2rem;"/>
                        </div>
                        <div id="photoprint_price">
                            <div>Стоимость: <span id="price">0</span> руб.</div>
                            <div>
                                <input onclick="showOrderForm();" type="button"
                                       value="Оформить заказ >>>"/>
                            </div>
                            <div class="count_files">Общее количество: <span
                                        id="files_count">0</span></div>
                        </div>

                        <!-- Modal -->
                        <div id="crop_desc" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal">&times;
                                        </button>
                                        <h4 class="modal-title">КАДРИРОВАНИЕ</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p> Если сказать в двух словах, то кадрирование - это
                                            подстройка исходного изображения под определенный
                                            формат (размеры, соотношение сторон и т.д.). При
                                            этом часть исходного изображения может остаться за
                                            границами печати (если конечно оно не было заранее
                                            подготовлено под нужный формат). </p>
                                        <p> Таким образом, если соотношение сторон исходного
                                            изображения не соответствует выбранному формату, то
                                            существует два варианта печати: </p>
                                        <ol>
                                            <li>
                                                <p><strong>С КАДРИРОВАНИЕМ</strong> <img
                                                            style="display: block;"
                                                            src="/img/uploadphoto/crop_001.jpg"/>
                                                <div style="font-style: italic;"><span
                                                            style="color: #01c478; font-weight: bold;">Плюсы:</span>
                                                    Изображение будет занимать всю область
                                                    распечатанной фотографии.
                                                </div>
                                                <div style="font-style: italic;"><span
                                                            style="color: #b52e28; font-weight: bold;">Минусы:</span>
                                                    Часть изображения, не вписавшаяся в
                                                    формат, будет обрезана.
                                                </div>
                                                </p>
                                            </li>
                                            <li>
                                                <p><strong>БЕЗ КАДРИРОВАНИЯ</strong> <img
                                                            style="display: block;"
                                                            src="/img/uploadphoto/crop_002.jpg"/>
                                                <div style="font-style: italic;"><span
                                                            style="color: #01c478; font-weight: bold;">Плюсы:</span>
                                                    Изображение будет напечатано полностью.
                                                    Никакая часть кадра не теряется.
                                                </div>
                                                <div style="font-style: italic;"><span
                                                            style="color: #b52e28; font-weight: bold;">Минусы:</span>
                                                    Возможно появление белых полей по краям
                                                    напечатанного снимка, но Вы всегда
                                                    сможете обрезать их самостоятельно.
                                                </div>
                                                </p>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button"
                                                data-dismiss="modal">Закрыть
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="recomended_products" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal">&times;
                                        </button>
                                    </div>
                                    <div class="modal-body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
