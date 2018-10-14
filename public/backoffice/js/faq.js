/**
 * CMS (plugins summernote)
 */
$(function () {
    $('#tz_service_metiermanagerbundle_faq_translations_fr_faqtQuestion, #tz_service_metiermanagerbundle_faq_translations_fr_faqttResponse').summernote({
        lang: 'fr-FR',
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });

    $('#tz_service_metiermanagerbundle_faq_translations_en_faqtQuestion, #tz_service_metiermanagerbundle_faq_translations_en_faqttResponse').summernote({
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });
})
