jQuery(document).ready(function($){$(".kt_swatches_attribute_panel .kt_attribute_label").click(function(t){t.preventDefault();var e=$(this).siblings(".kt_attribute_panel");return e.hasClass("panel_open")?(e.removeClass("panel_open"),$(this).removeClass("panel_active")):(e.addClass("panel_open"),$(this).addClass("panel_active")),!1}),$(".kt_swatches_attribute_panel .kt_swatches_attribute_table_subhead").click(function(t){t.preventDefault();var e=$(this).siblings(".kt_swatches_attribute_single_options");return e.hasClass("panel_open")?e.removeClass("panel_open"):e.addClass("panel_open"),!1}),$(".kt_swatches_attribute_panel .kt_swatch_color").each(function(){$(this).wpColorPicker({change:function(t,e){var s=$(this);s.closest(".kt_swatches_attribute_single").find(".kt_sas_preview_item").css("background-color",e.color.toString())},clear:function(){},hide:!0,palettes:!0})}),$(".kt_swatches_attribute_panel").on("change",".kt_select_swatches_type",function(){var t=$(this).find(":selected").val();"color_image"==t?($(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table").addClass("panel_open"),$(this).closest(".kt_attribute_panel").find(".kt_attribute_extra_settings").addClass("panel_open")):"default"==t?($type=$(this).closest(".kt_swatches_attribute_panel").data("default-type"),"color_image"==$type?($(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table").addClass("panel_open"),$(this).closest(".kt_attribute_panel").find(".kt_attribute_extra_settings").addClass("panel_open")):($(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table").removeClass("panel_open"),$(this).closest(".kt_attribute_panel").find(".kt_attribute_extra_settings").removeClass("panel_open"))):($(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table").removeClass("panel_open"),$(this).closest(".kt_attribute_panel").find(".kt_attribute_extra_settings").removeClass("panel_open"))}),$(".kt_swatches_attribute_panel").on("change",".kt_select_swatches_size",function(){var t=$(this).find(":selected").val();"default"==t?($size_value=$(this).closest(".kt_swatches_attribute_panel").data("default-size"),$(this).closest(".kt_swatches_attribute_panel").find(".kt_sas_preview_item").css("width",$size_value+"px"),$(this).closest(".kt_swatches_attribute_panel").find(".kt_sas_preview_item").css("height",$size_value+"px"),$(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table_subhead").css("line-height",$size_value+"px")):($(this).closest(".kt_swatches_attribute_panel").find(".kt_sas_preview_item").css("width",t+"px"),$(this).closest(".kt_swatches_attribute_panel").find(".kt_sas_preview_item").css("height",t+"px"),$(this).closest(".kt_swatches_attribute_panel").find(".kt_swatches_attribute_table_subhead").css("line-height",t+"px"))}),$(".kt_swatches_attribute_single_options").on("change",".kt_select_swatches_type_single",function(){var t=$(this).find(":selected").val(),e=$(this).closest(".kt_swatches_attribute_single");if("color"==t){e.find(".kt_sas_option_image").css("display","none"),e.find(".kt_sas_option_color").css("display","block");var s=e.find(".kt_swatch_color").val();e.find(".kt_sas_preview_item").css("background-color",s),e.find(".kt_sas_preview_item").css("background-image","none"),e.find(".kt_sas_type").html("Color")}else{e.find(".kt_sas_option_image").css("display","block"),e.find(".kt_sas_option_color").css("display","none");var a=e.find(".kt_swatch_image").val();e.find(".kt_sas_preview_item").css("background-image","url("+a+")"),e.find(".kt_sas_type").html("Image")}})}),function($){"use strict";$.kt_swatch_imgupload=$.kt_swatch_imgupload||{},$(document).ready(function(){$.kt_swatch_imgupload()}),$.kt_swatch_imgupload=function(){$("body").on({click:function(t){var e=$(this).closest(".kt_swatches_attribute_single");if("undefined"!=typeof wp&&wp.media){t.preventDefault();var s,a=$(this);if(s)return void s.open();s=wp.media({multiple:!1,library:{type:"image"}}),s.on("select",function(){var t=s.state().get("selection").first();s.close(),e.find(".kt_swatch_image").val(t.attributes.url),e.find(".kt_swatch_image_id").val(t.attributes.id);var a=t.attributes.url;a="undefined"!=typeof t.attributes.sizes&&"undefined"!=typeof t.attributes.sizes.thumbnail?t.attributes.sizes.thumbnail.url:t.attributes.icon,e.find(".kt_sas_preview_item").css("background-image","url("+a+")")}),s.open()}}},".kt_swatches_upload_button")}}(jQuery);