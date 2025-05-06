// Function to update line numbers dynamically
function updateLineNumbers() {
    var textArea = document.getElementById('editor');
    var lineNumbers = document.getElementById('line-numbers');
    
    var lines = textArea.value.split('\n').length; // Count the lines
    var numbers = '';
    
    for (var i = 1; i <= lines; i++) {
        numbers += i + '<br>';
    }
    
    lineNumbers.innerHTML = numbers; // Update the line numbers
}

// Event listener to update the line numbers when typing or pressing Enter
document.getElementById('editor').addEventListener('input', updateLineNumbers);
document.getElementById('editor').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        setTimeout(updateLineNumbers, 0); // Update after line break
    }
});

// Call the function to update line numbers on page load
window.onload = updateLineNumbers;
