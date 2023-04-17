const inputFields = document.getElementById('input-fields');

    document.getElementById('graph-select').addEventListener('change', (event) => {
        inputFields.innerHTML = '';

        const selectedOption = event.target.value;
        if (selectedOption === 'angulargauge') {
            const label1 = document.createElement('label');
            label1.textContent = "Enter Value:";
            label1.setAttribute('for', 'input-1');
            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'input-1';

            inputFields.appendChild(label1);
            inputFields.appendChild(input1);
        } else if (selectedOption === 'pie2d') {
            const label1 = document.createElement('label');
            label1.textContent = "Enter Value:";
            label1.setAttribute('for', 'input-1');
          
            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'input-1';
            
            inputFields.appendChild(label1);
            inputFields.appendChild(input1);

            const label2 = document.createElement('label');
            label2.textContent = "Enter Value:";
            label2.setAttribute('for', 'input-2');

            const input2 = document.createElement('input');
            input2.type = 'text';
            input2.name = 'input-2';
            
            inputFields.appendChild(label2);
            inputFields.appendChild(input2);

            const label3 = document.createElement('label');
            label3.textContent = "Enter Value:";
            label3.setAttribute('for', 'input-3');

            const input3 = document.createElement('input');
            input3.type = 'text';
            input3.name = 'input-3';

            inputFields.appendChild(label3);
            inputFields.appendChild(input3);
        } else if (selectedOption === '') {
            //do nothing
        } else {
            const label1 = document.createElement('label');
            label1.textContent = "XAxis Name:";
            label1.setAttribute('for', 'input-1');

            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.name = 'input-1';

            inputFields.appendChild(label1);
            inputFields.appendChild(input1);

            const label2 = document.createElement('label');
            label2.textContent = "YAxis Name:";
            label2.setAttribute('for','input-2');

            const input2 = document.createElement('input');
            input2.type = 'text';
            input2.name = 'input-2';

            inputFields.appendChild(label2);
            inputFields.appendChild(input2);
        }
    });