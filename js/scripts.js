
// Отправка формы
var contactFormEl = $(".contact-form");
var contactFormStatusEl = contactFormEl.find(".contacts-form__status-message");
var emailInputEl = contactFormEl.find("[name = email]");
var phoneInputEl = contactFormEl.find("[name = phone]");
var validatedFields = { email: true, phone: true };
var mandatoryFields = ["name", "phone"];

contactFormEl.submit(function (e) {
    e.preventDefault();
    var inputsFilled = mandatoryInputsFilled();
    if (inputsFilled && !contactFormHasError()) {
        $.post("mail.php", {
            name: contactFormEl.find("[name = name]").val(),
            email: contactFormEl.find("[name = email]").val(),
            tel: contactFormEl.find("[name = phone]").val(),
            message: contactFormEl.find("[name = comments]").val(),
            position: contactFormEl.find("[name = position]").val(),
            lastname: contactFormEl.find("[name = last_name]").val(),
            city: contactFormEl.find("[name = city]").val(),
            industry: contactFormEl.find("[name = industry]").val(),
            need: contactFormEl.find("[name = need]").val(),
            question: contactFormEl.find("[name = question]").val(),
        })
            .done(function () {
                contactFormStatusEl.text(
                    "Дякуємо за заявку. Ми зв'яжемося з Вами найближчим часом."
                );
                contactFormStatusEl.css("display", "block");
                contactFormStatusEl.css("color", "#7aba41");
            })
            .fail(function () {
                contactFormStatusEl.text("Виникла помилка, спробуйте пізніше");
                contactFormStatusEl.css("display", "block");
                contactFormStatusEl.css("color", "red");
            })
            .always(function () {
                contactFormEl.find("input").each(function () {
                    $(this).val("");
                });
            });
    } else if (!inputsFilled) {
        contactFormStatusEl.text("Обов'язкові поля мають бути заповнені");
        contactFormStatusEl.css("display", "block");
        contactFormStatusEl.css("color", "red");
    } else {
        contactFormStatusEl.css("display", "none");
    }
});

function mandatoryInputsFilled() {
    var result = true;
    mandatoryFields.forEach((inputType) => {
        if (contactFormEl.find(`input[name=${inputType}]`).val() === "")
            result = false;
    });
    return result;
}
function contactFormHasError() {
    return Object.values(validatedFields).includes(false);
}