/**
 * JavaScript de funciones auxiliares.
 * 
 * Usando el símbolo $ para variables de tipo objeto de jQuery.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

/**
 * Objeto para namespace.
 */
var aux = {};

/**
 * Retrieves a form's data and converts it to a JSON string
 * 
 * @param {jQuery} $form
 */
aux.jQueryFormToJsonString = ($form) =>
{
    var resultObject = {};

    // Get form inputs' values
    const formArray = $form.serializeArray();

    // Transfer data
    for (i = 0; i < formArray.length; i++) {
        const key = formArray[i].name;
        const value = formArray[i].value;

        // If key was already added
        if (resultObject[key]) {
            // If position was already an array
            if (Array.isArray(resultObject[key])) {
                resultObject[key].push(value);
            } else {
                // Else, create an array and insert existing and new values
                const existing = resultObject[key];
                resultObject[key] = [ existing, value ];
            }
        } else {
            resultObject[key] = value;
        }
    }

    return JSON.stringify(resultObject);
}

/**
 * Finds an object with a specific attribute in an array.
 * 
 * @param {array} array
 * @param {string} attributeName
 * @param {string} attributeValue
 */
aux.findObjectInArray = (array, attributeName, attributeValue) =>
{
    for (var i = 0; i < array.length; i++) {
        if (array[i][attributeName] === attributeValue) {
            return array[i];
        }
    }
    
    return null;
}

/**
 * Empties all form controls
 * 
 * @param {jQuery} $form
 */
aux.doEmptyForm = ($form) =>
{
    $form.find('input:not(.do-not-empty), select:not(.do-not-empty), textarea:not(.do-not-empty)').val('');
    $form.find('input[type="checkbox"]:not(.do-not-empty), input[type="radio"]:not(.do-not-empty)').prop('checked', false);
    $form.find('select:not(.do-not-empty), textarea:not(.do-not-empty)').empty();

    const $formElement = $form.find('form');

    for (var i = 0; i < $formElement.length; i++)
        $formElement[i].reset();
}