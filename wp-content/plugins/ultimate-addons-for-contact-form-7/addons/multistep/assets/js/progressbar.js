(function ($) {

    $(document).ready(function () {
        var navListItems  = $('.uacf7-steps div.setup-panel div a'),
            allWells      = $('.uacf7-step'),
            allNextBtn    = $('.uacf7-next'),
            allPrevBtn    = $('.uacf7-prev'),
            allStepTitle  = $('.step-title');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                title   = $($(this).attr('title-id')),
                $item   = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('uacf7-btn-active').addClass('uacf7-btn-default');
                $item.addClass('uacf7-btn-active');
                allWells.hide();
                $target.show();
                allStepTitle.hide();
                title.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function () {
            var curStep = $(this).closest(".uacf7-step"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepSteps.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function () {
            var curStep = $(this).closest(".uacf7-step"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            //if (isValid)
                //nextStepWizard.removeAttr('disabled').trigger('click');
        });

        //$('div.setup-panel div a.uacf7-btn-active').trigger('click');
        $('#step-1.uacf7-step.step-content.step-start').show();
    });
})(jQuery);
