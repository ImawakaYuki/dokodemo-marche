!function($){var e=wp.media;e.view.Settings.Gallery=e.view.Settings.Gallery.extend({render:function(){function t(){var e=i.find("select[name=kt_type]").val(),t=i.find("select[name=columns]").closest("label.setting"),l=i.find(".slider-settings");"default"===e||"carousel"===e?t.show():t.hide(),"slider"===e?l.show():l.hide()}var i=this.$el;return e.view.Settings.prototype.render.apply(this,arguments),i.append(e.template("custom-gallery-setting")),e.gallery.defaults.type="default",this.update.apply(this,["type"]),e.gallery.defaults.caption="default",this.update.apply(this,["caption"]),e.gallery.defaults.masonry="default",this.update.apply(this,["masonry"]),i.find("select[name=size]").closest("label.setting").hide(),i.find(".slider-settings").hide(),t(),i.find("select[name=kt_type]").on("change",function(){t()}).change(),this}})}(jQuery);