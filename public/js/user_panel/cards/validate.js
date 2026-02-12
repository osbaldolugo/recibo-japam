//Validate card number with regex expressions
window.Parsley.addValidator("cardPayment", {
    requirementType: "string",
    validateString: function (value, requirement) {
        if (
            value.match('^4[0-9]{6,}$') == null &&
            value.match("^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$ ") == null
        ) {
            return false;
        } else {
            return true;
        }
    },
    messages: {
        es: "El no de tarjeta no es válido"
    }
});

$(function () {

    //To know card type
    $("#number").on("keyup", function () {
        var value = $(this).val();

        if (!value) $("#cards div").removeClass("hidden");
        else {
            switch (value.substr(0, 1)) {
                case "4":
                    $("#cards div:first-child").removeClass("hidden");
                    $("#cards div:last-child").addClass("hidden");
                    break;

                case "5":
                    $("#cards div:last-child").removeClass("hidden");
                    $("#cards div:first-child").addClass("hidden");
                    break;
            }
        }
    });

});