order = "";
// promoName = "";
// discount = 0;
// promoTotal = 0;
// promoSpec = 0;
secureKey = "";
// printMode = "premium";
// realPrice = 0;
orderConfirmed = 0;

function leaveOrder() {

    $.ajax({
        type: "POST",
        url: "/uploadphoto/stop/",
        async: false
    });
};

function toggle_mode(model) {
    model.prevantDefault;
    console.log(model);
    if (!jQuery(model).hasClass("chosen")) {
        jQuery(".toggle_mode > div").removeClass("chosen");
        jQuery(model).addClass("chosen");
        if (jQuery(model).attr("data-mode") === "express") {
            window.printMode = "express";
            jQuery("div.large_sizes").css("display", "none");
            if (jQuery(".large_sizes > a").hasClass("chosen")) {
                jQuery("div#sizes a").removeClass("chosen");
                jQuery("div#sizes a:contains(\"10x15\")").addClass("chosen");
                jQuery("div.uploader").slideUp("slow");
                jQuery("div#drag-and-drop-zone-10x15").slideDown("slow");
            }
        }
        calcPrice();
    }
}

function showPhotoprintForm() {
    jQuery("h3#photoprint_order").hide("slow");
    if (window.order !== "" && window.order !== "processing") {
        if (jQuery("div#photoprint_form").css("display") === "none") {
            jQuery("div#photoprint_form").slideDown("slow");
            jQuery("div.arrow").hide("slow");
        } else {
            jQuery("div#photoprint_form").slideUp("slow");
            jQuery("div.arrow").show("slow");
        }
    } else if ((window.order === "")) {
        window.order = "processing";
        jQuery("#loading").show("slow");
        setTimeout(function () {
            $.ajax({
                type: "POST",
                url: "/uploadphoto/numorders",
                data: {data: "test"},
                async: false,
                success: function (data) {
                    window.order = data.orderNumber;
                    window.secureKey = data.secureKey;
                    view = data.tpl;
                    window.block = data.block;
                }
            });

            if (jQuery("#loading").css("display") !== "none") {
                jQuery("#loading").hide("slow");
                showPhotoprintForm();
            }
            jQuery(".toggle_mode > div").tooltip({
                animation: false
            });
            jQuery("#photoprint_form > #sizes a").each(function () {
                i = jQuery(this).text();
                initUploader(i, order);

            });

            window.onbeforeunload = leaveOrder;
            jQuery(".uploader").each(function () {
                var $this = jQuery(this);
                $this.find(".allmate").eq(0).on("click", function (e) {
                    e.preventDefault();
                    $this.find(".file .paper").val("mate");
                });
                $this.find(".allglossy").eq(0).on("click", function (e) {
                    e.preventDefault();
                    $this.find(".file .paper").val("glossy");
                });
            });
        }, 1000);
    }
}

function removeImage(var7) {
    jQuery("#" + var7).hide("slow", function () {
        jQuery(this).remove();
        calcPrice();
    });
}

function add_file(cnt, file, size) {

    productBlock = window.block.replace(/{{size}}/g, size).replace(/{{count}}/g, cnt).replace(/{{title}}/g, file.name);
    jQuery("#fileList-" + size).prepend(productBlock);
}

function update_file_status(cnt, status, var10, size) {
    var _0xbc7cx1c = jQuery("#uploadFile" + size + "_" + cnt).find("span.status");
    if (status !== "uploading") {
        jQuery("#uploadFile" + size + "_" + cnt + " .progress").css("opacity", "0");
        _0xbc7cx1c.addClass(status).addClass(var10).css("display", "block");
        _0xbc7cx1c.html("");
    }
    if (status === "error") {
        select = jQuery("div#uploadFile" + size + "_" + cnt);
        select.find("div.progress").css("background", "#b52e28");
        select.find("input.qty").addClass(var9);
        jQuery("div#uploadFile" + size + "_" + cnt + " div.info div.preview_image img").remove();
        jQuery("div#uploadFile" + size + "_" + cnt + " div.info div.preview_image").append('<img src="/img/uploadphoto/error.png" />');
    }
}

function initUploader(size) {
    photo_price = stock_price[size];
    jQuery("#drag-and-drop-zone-" + size).dmUploader({
        url: "/uploadphoto/uploadfiles/",
        dataType: "json",
        extFilter: "jpg;jpeg;png",
        onInit: function () {
        },
        onBeforeUpload: function (cnt) {
            update_file_status(cnt, "uploading", "", size);
            jQuery("#drag-and-drop-zone-" + size + " img#upload_progress").css("display", "inline-block");
            jQuery("#uploadFile" + size + "_" + cnt).slideDown("slow");
        },
        onNewFile: function (cnt, title) {
            add_file(cnt, title, size);
        },
        onComplete: function () {
            jQuery("#drag-and-drop-zone-" + size + " img#upload_progress").css("display", "none");
        },
        onUploadProgress: function (cnt, proc) {
            proc = proc + "%";
            $("#uploadFile" + size + "_" + cnt + " .progress-bar").css("width", proc);
        },
        onUploadSuccess: function (cnt, answer) {
            if (answer.status === "error") {
                jQuery.fancybox.open({
                    src: "<p style=\"text-align: center;\">" + answer.textError + "</p>",
                    type: "html"
                }, {
                    animationEffect: "zoom-in-out"
                });
                removeImage("uploadFile" + size + "_" + cnt);
            } else {
                update_file_status(cnt, "success", "fa fa-check", size);
                jQuery("div#uploadFile" + size + "_" + cnt).find("input.qty").addClass("success");
                jQuery("#uploadFile" + size + "_" + cnt)
                    .find("img").eq(0)
                    .attr("src", answer.status.min)
                    .css("cursor", "zoom-in")
                    .on("click", function () {
                        jQuery.fancybox.open({
                            src: answer.status.max,
                            caption: answer.status.max.split("/").pop(),
                            protect: true
                        }, {
                            animationEffect: "zoom-in-out"
                        });
                    });
                calcPrice();
            }
        },
        onUploadError: function (cnt) {
            update_file_status(cnt, "error", "fa fa-close", size);
        },
        onFileTypeError: function (var7) {
            jQuery.fancybox.open({
                src: '<p style="text-align: center;">Файл <b>' + var7.name + '</b> должен быть изображением!</p>',
                type: "html"
            }, {
                animationEffect: "zoom-in-out"
            });
        },
        onFileSizeError: function (var7) {
            jQuery.fancybox.open({
                src: '<p style="text-align: center;">Файл <b>' + var7.name + '</b> не может быть загружен: <br>Превышен допустимый размер файла!</p>',
                type: "html"
            }, {
                animationEffect: "zoom-in-out"
            });
        },
        onFileExtError: function (var7) {
            jQuery.fancybox.open({
                src: '<p style="text-align: center;">Файл <b>' + var7.name + '</b> <br>Недопустимое расширение файла</p>',
                type: "html"
            }, {
                animationEffect: "zoom-in-out"
            });
        },
        onFallbackMode: function (var17) {
            alert("Browser not supported(do something else here!): " + var17);
        }
    });
}

function calcPrice() {
    var var18 = jQuery("div#photoprint_price");
    var var19 = "";
    // Общее кол-во фото.
    var total_photo = 0;
    jQuery(".file input.qty").each(function () {
        if (!jQuery(this).hasClass("error") && jQuery(this).hasClass("success")) {
            total_photo += parseInt(jQuery(this).val())
        }
    });

    // Определение на странице всех доступных списков фотограций и подсчет их стоимости
    var count = [];
    jQuery(".filelist").each(function () {
        id = jQuery(this).attr("id");
        var index = id.split("-").pop();
        count[index] = 0;
        jQuery("div#" + id + " .file input.qty").each(function () {
            if (!jQuery(this).hasClass("error") && jQuery(this).hasClass("success")) {
                count[index] += parseInt(jQuery(this).val());
            }
        });
        jQuery("a:contains(" + index + ")").next().html(count[index]);
    });

    //Считаем цену
    price = 0;
    for (var key in count) {
        price += count[key] * stock_price[key];
    }

    if (window.promoName === "law_and_order") {
        window.realPrice = price;
        if (window.realPrice > 0) {
            var18.show("slow");
        }
    }
    if (var18.css("display") === "none" && price !== 0 && total_photo !== 0) {
        var18.show("slow");
    }
    ;
    jQuery('.size_cnt').each(function () {
        if (parseInt(jQuery(this).html()) > 0) {
            jQuery(this).addClass('green_cnt')
        } else {
            jQuery(this).removeClass('green_cnt')
        }
    });
    jQuery('span#files_count').html(total_photo + ' шт.');
    jQuery('span#price').html(price);
    jQuery('span#order_price').html('<span>' + price + ' руб.</span>' + var19);
    jQuery('.uploader').each(function () {
        var var39 = 0;
        var var40 = 0;
        jQuery(this).find('.file .qty').each(function () {
            var39 += parseInt(jQuery(this).val());
            if (jQuery(this).hasClass('success')) {
                var40 += parseInt(jQuery(this).val())
            }
        });
        if (var39 < 1) {
            jQuery(this).find('.uploader_counter').html('');
            jQuery(this).find('.mass_control').hide('slow');
        } else {
            jQuery(this).find('.uploader_counter').html('Успешно принято фотографий: ' + var40 + ' из ' + var39);
            jQuery(this).find('.mass_control').show('slow');
        }
    });
    if (price == 0 && total_photo == 0) {
        var18.hide('slow')
    }
}

function showOrderForm() {

    if (jQuery('span.status').is('.uploading:not(.success)')) {
        alert('Некоторые Ваши файлы находятся в процессе загрузки. Пожалуйста, дождитесь окончания процесса.');
        return false
    }
    ;
    jQuery('span#order_num').html(window.order);
    window.order = 'processing';
    jQuery('div#photoprint_form').slideUp('slow');
    jQuery('div#photoprint_price').hide('slow');
    jQuery('div.order_form').slideDown('slow');
}

function hideOrderForm() {
    window.order = jQuery('span#order_num').text();
    jQuery('div#photoprint_form').slideDown('slow');
    window.calcPrice();
    jQuery('#extended_products').html('');
    jQuery('div.order_form').slideUp('slow');
    jQuery('div#map').html('')
}

jQuery('form').on('beforeSubmit', function () {
    jQuery('div.order_form').slideUp('slow');
    jQuery('h3#photoprint_order').slideUp('slow');
    jQuery('#loading').show('slow');
    var order = [];
    jQuery('div.uploader div.file').each(function () {
        if (!jQuery(this).find('.status').hasClass('error')) {
            order.push({
                fileName: jQuery(this).find('.filename').text(),
                qty: parseInt(jQuery(this).find('.qty').val()),
                paperType: jQuery(this).find('.paper').val(),
                printSize: jQuery(this).attr('size'),
                kadr: jQuery(this).parent().parent().find('.switch input').is(':checked')

            })
        }
    });
    form = $("#OrderFormPhoto :input");
    data = {};
    form.each(function () {
        data[this.name] = $(this).val();
    });
    data["orderNum"] = jQuery('span#order_num').text();
    data["totalPrice"] = jQuery('span#order_price span').html();
    data["count"] = jQuery('span#files_count').text();
    data["OrderPhoto[order]"] = JSON.stringify(order);

    console.log(data);
    jQuery.post('/uploadphoto/orderphoto', data)
        .done(function (data) {
            // data = JSON.parse(data);
            console.log(data);
            orderConfirmed = 1;
            setTimeout(function () {
                switch (data.status) {
                    case 'ok':
                        jQuery('div#loading').html('<h2 style="text-align: center;">Ваш заказ №' + data.id + ' успешно оформлен!</h2><h4 style="text-align: center;">На ваш email было отправлено письмо с информацией по заказу и оплате. В ближайшее время наши сотрудники с вами свяжутся. Обратите внимание, что в зависимости от уровня фильтрации, письмо с реквизитами может попасть в "Спам".</h4>');
                        break;
                    default:
                        jQuery('div#loading').html('<h2 style="text-align: center; color: #b52e28;">Произошла неизвестная ошибка :(</h2>')
                }
            }, 2000)
        });
    return false;
});

jQuery(document).ready(function () {
    //Переключение размеров фото.
    jQuery('div#sizes a').click(function (e) {
        e.preventDefault();
        if (!jQuery(this).hasClass('chosen')) {
            jQuery('div#sizes a').removeClass('chosen');
            jQuery(this).addClass('chosen');
            jQuery('div.uploader').slideUp('slow');
            jQuery('div#drag-and-drop-zone-' + jQuery(this).text().replace(/\./g, '_')).slideDown('slow')
        }
    });
    jQuery('#upload_block').on('click', '.qtyplus', function (f) {

        console.log(window.tpl);
        f.preventDefault();
        fieldName = jQuery(this).attr('field');
        var photo = parseInt(jQuery('input[name=' + fieldName + ']').val());
        if (!isNaN(photo) && photo >= 1 && photo < 9999) {
            jQuery('input[name=' + fieldName + ']').val((photo + 1) + ' шт.')
        } else {
            jQuery('input[name=' + fieldName + ']').val(1 + ' шт.')
        }
        calcPrice()
    });
    jQuery('#upload_block').on('click', '.qtyminus', function (f) {
        f.preventDefault();
        fieldName = jQuery(this).attr('field');

        var photo = parseInt(jQuery('input[name=' + fieldName + ']').val());
        if (!isNaN(photo) && photo > 1 && photo < 9999) {
            jQuery('input[name=' + fieldName + ']').val((photo - 1) + ' шт.')
        } else {
            jQuery('input[name=' + fieldName + ']').val(1 + ' шт.')
        }
        calcPrice()
    });
});