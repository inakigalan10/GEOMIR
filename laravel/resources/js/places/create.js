// Load our customized validationjs library
import Validator from '../validator'
 
// Submit form ONLY when validation is OK
const form = document.getElementById("create")
 
form.addEventListener("submit", function( event ) {
   // Reset errors messages
   for(let i = 0; i < document.querySelectorAll('.alert').length; i++){
        document.querySelectorAll('.alert')[i].innerHTML = "";
        document.querySelectorAll('.alert')[i].hidden = true; 
   }
   // Create validation
   let data = {
       "upload": document.getElementsByName("upload")[0].value,
       "name": document.getElementsByName("name")[0].value,
       "description": document.getElementsByName("description")[0].value,
       "latitude": document.getElementsByName("latitude")[0].value,
       "longitude": document.getElementsByName("longitude")[0].value,
       "category_id": document.getElementsByName("category_id")[0].value,
       "visibility_id": document.getElementsByName("visibility_id")[0].value,
   }
   let rules = {
       "upload": "required",
       "name": "required",
       "description": "required",
       "latitude": "required",
       "longitude": "required",
       "category_id": "required",
       "visibility_id": "required",
   }
   let validation = new Validator(data, rules)
   // Validate fields
   if (validation.passes()) {
       // Allow submit form (do nothing)
       console.log("Validation OK")
   } else {
       // Get error messages
       let errors = validation.errors.all()
       console.log(errors)
       // Show error messages
       for(let inputName in errors) {
           let div =  document.querySelector('#'+inputName)
            div.querySelector('.alert').innerHTML = errors[inputName]
            div.querySelector('.alert').hidden = false; 
       }
       // Avoid submit
       event.preventDefault()
       return false
   }
})
