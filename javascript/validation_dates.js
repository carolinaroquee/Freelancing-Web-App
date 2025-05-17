document.addEventListener('DOMContentLoaded', function() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    // Função para verificar se há datas duplicadas
    function validateDates() {
      const selectedDates = [];
      let isValid = true;
      
      dateInputs.forEach(input => {
        const selectedDate = input.value;
        if (selectedDates.includes(selectedDate)) {
          isValid = false;
          input.setCustomValidity('This date has already been selected.');
        } else {
          selectedDates.push(selectedDate);
          input.setCustomValidity(''); // Remove o erro de data duplicada
        }
      });

      return isValid;
    }

    // Adiciona o evento de verificação ao submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      if (!validateDates()) {
        event.preventDefault(); // Impede o envio do formulário se houver erro
        alert('Please select unique dates.');
      }
    });
  });

