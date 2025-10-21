<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Builder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <style>
    .iti {
      width: 100% !important;
    }
    .iti__selected-flag {
      background-color: #dbeafe !important;
      border-radius: 0.25rem 0 0 0.25rem !important;
    }
    .iti__country-list {
      width: 500% !important;
    }
 
   
    .live-preview-container {
      transition: all 0.3s ease-in-out;
    }
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .preview-content {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    
    .auto-save-indicator {
      transition: all 0.3s ease;
    }
    
    .saving {
      background-color: #f59e0b;
      animation: pulse 1.5s infinite;
    }
    
    .saved {
      background-color: #10b981;
    }
    
    .error {
      background-color: #ef4444;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <main class="max-w-7xl mx-auto mt-8 p-6">
    
  
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      
    
      <div class="bg-white shadow-lg p-6 rounded-lg">
      
        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
              <div id="autoSaveIndicator" class="w-3 h-3 bg-gray-400 rounded-full auto-save-indicator"></div>
              <div>
                <span id="autoSaveText" class="text-sm font-medium text-gray-600">Idle</span>
                <div id="lastSaved" class="text-xs text-gray-500"></div>
              </div>
            </div>
            <button type="button" onclick="clearDraft()" class="text-xs text-red-500 hover:text-red-700">
              Clear Draft
            </button>
          </div>
        </div>

       
        <div class="mb-6">
          <h2 class="text-lg font-semibold mb-2">Resume Progress</h2>
          <div class="w-full bg-gray-200 h-1.5">
            <div id="progressBar" class="bg-blue-600 h-1.5 transition-all duration-300" style="width:0%"></div>
          </div>
          <div class="flex justify-between text-sm text-gray-500 mt-1">
            <span>Get Started</span>
            <span id="progressText">0% Complete</span>
          </div>
        </div>

      
        <div id="messageContainer" class="hidden mb-4 p-4 rounded-lg"></div>

        <form method="POST" action="{{ route('resume.download') }}" id="resumeForm">
          @csrf
          <input type="hidden" name="template" id="selectedTemplate" value="">
          <input type="hidden" name="phone" id="fullPhone">

          
          <section class="space-y-4">
            <h3 class="text-xl font-semibold pb-1 text-black">Personal Details</h3>
            <p class="text-gray-600 text-sm">Enter your basic personal information, such as your name, contact details, and nationality.</p>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <div class="relative">
                  <input type="tel" id="phone" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field">
                </div>
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                <input type="text" name="occupation" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <select name="country" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
                  <option value="">Select Country</option>
                   @include('partials.country-options')
                </select>
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <input type="date" name="dob" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                <select name="nationality" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
                  <option value="">Select Nationality</option>
                   @include('partials.nationality-options')
                </select>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
              <select name="gender" class="p-2 w-full bg-blue-50 border border-blue-200 rounded required-field" onchange="handleInputChange()">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
                <option value="Prefer not to say">Prefer not to say</option>
              </select>
            </div>
          </section>

         
          <section id="additionalDetails" class="space-y-4 mt-6 hidden">
            <h3 class="text-xl font-semibold pb-1 text-black">Additional Details</h3>
            <p class="text-gray-600 text-sm">Include hobbies, interests, or personal achievements.</p>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Hobbies</label>
              <textarea name="hobbies" class="w-full p-3 bg-blue-50 border border-blue-200 rounded additional-field" placeholder="e.g., Reading, Traveling, Photography" oninput="handleInputChange()"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Interests</label>
              <textarea name="interests" class="w-full p-3 bg-blue-50 border border-blue-200 rounded additional-field" placeholder="e.g., AI Technology, Environmental Conservation" oninput="handleInputChange()"></textarea>
            </div>
          </section>

          <div class="text-center my-6">
            <button type="button" onclick="toggleAdditional()" class="px-6 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200">
              <span id="additionalIcon">+</span> <span id="additionalText">Show Additional Details</span>
            </button>
          </div>

          
          <section class="space-y-3">
            <h3 class="text-xl font-semibold pb-1 text-black">Professional Summary</h3>
            <p class="text-gray-600 text-sm">Provide a brief overview of your professional background and career objectives.</p>
            <div>
              <textarea name="summary" class="w-full p-3 h-24 bg-blue-50 border border-blue-200 rounded required-field" placeholder="Enter your professional summary..." oninput="handleInputChange()"></textarea>
            </div>
          </section>

         
          <section class="mt-6 space-y-2">
            <h3 class="text-xl font-semibold pb-1 text-black">Employment History</h3>
            <p class="text-gray-600 text-sm">List your previous jobs in reverse chronological order.</p>
            <div id="employmentContainer"></div>
            <div class="text-center">
              <button type="button" onclick="addEmployment()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
                <span class="text-blue-600">+</span> Add Job
              </button>
            </div>
          </section>

         
          <section class="mt-6 space-y-2">
            <h3 class="text-xl font-semibold pb-1 text-black">Education</h3>
            <p class="text-gray-600 text-sm">Enter your academic qualifications and institutions.</p>
            <div id="educationContainer"></div>
            <div class="text-center">
              <button type="button" onclick="addEducation()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
                <span class="text-blue-600">+</span> Add Education
              </button>
            </div>
          </section>

         
          <section class="mt-6 space-y-2">
            <h3 class="text-xl font-semibold pb-1 text-black">Languages</h3>
            <p class="text-gray-600 text-sm">Select the languages you know and your proficiency level.</p>
            <div id="languageContainer"></div>
            <div class="text-center">
              <button type="button" onclick="addLanguage()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
                <span class="text-blue-600">+</span> Add Language
              </button>
            </div>
          </section>

         
          <section class="mt-6 space-y-2">
            <h3 class="text-xl font-semibold pb-1 text-black">Skills</h3>
            <p class="text-gray-600 text-sm">Include key skills, technical abilities, and tools you are proficient in.</p>
            <div id="skillsContainer"></div>
            <div class="text-center">
              <button type="button" onclick="addSkill()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
                <span class="text-blue-600">+</span> Add Skill
              </button>
            </div>
          </section>

        
          <div class="text-center mt-8 flex justify-center gap-4 flex-wrap items-center">
            <button type="button" onclick="saveDraft()" class="px-6 py-3 font-bold text-blue-600 border border-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200">
              Save Draft
            </button>
            
            <div class="flex items-center gap-2">
              <select id="templateDropdown" class="p-3 border border-gray-300 rounded bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Template</option>
                <option value="template1">Professional Blue</option>
                <option value="template2">Modern Black</option>
                <option value="template3">Creative Green</option>
              </select>
              
              <button type="button" onclick="validateForm()" class="px-8 py-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 transition duration-200">
                Download PDF
              </button>
            </div>
          </div>
        </form>
      </div>

    
      <div class="bg-white shadow-lg p-6 rounded-lg sticky top-4">
        <h3 class="text-xl font-semibold mb-4 flex items-center">
          <span>Live Preview</span>
          <span id="autoSaveStatus" class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded hidden">
            Auto-saved
          </span>
        </h3>
        
        <div id="livePreview" class="live-preview-container border-2 border-dashed border-gray-300 rounded-lg p-6 min-h-[500px]">
          
          <div class="text-center text-gray-500 py-20">
            <div class="text-4xl mb-4">📝</div>
            <p class="text-lg font-medium">Please select a template to see preview</p>
          </div>
        </div>
        

        <div id="templatePreviewInfo" class="mt-4 p-3 rounded-lg text-sm">
          <strong>Selected Template:</strong> <span id="currentTemplateName"></span>
          <p class="text-xs mt-1" id="templateDescription"></p>
        </div>
      </div>
    </div>
  </main>

  <script>
   
    let phoneInput;
    let autoSaveInterval;
    let formChanged = false;
    let lastSaveTime = null;

    
    let employmentCounter = 0;
    let educationCounter = 0;
    let languageCounter = 0;
    let skillCounter = 0;


    document.addEventListener('DOMContentLoaded', function() {
        initializePhoneInput();
        initializeAutoSave();
        loadDraft();
        updateProgress();
        
        
        document.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', handleInputChange);
        });

       
        document.getElementById('templateDropdown').addEventListener('change', function() {
            selectTemplate(this.value);
        });

        
        addEmployment();
        addEducation();
        addLanguage();
        addSkill();
    });

  
    function initializePhoneInput() {
        phoneInput = window.intlTelInput(document.querySelector("#phone"), {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ['us', 'gb', 'ca', 'au'],
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/country/")
                    .then(response => response.text())
                    .then(countryCode => callback(countryCode))
                    .catch(() => callback("us"));
            }
        });

        document.getElementById('phone').addEventListener('input', function() {
            handleInputChange();
            if (phoneInput.isValidNumber()) {
                document.getElementById('fullPhone').value = phoneInput.getNumber();
            }
        });
    }

   
    function handleInputChange() {
        formChanged = true;
        updateProgress();
        debouncedPreviewUpdate();
    }

   
    function getFormData() {
        const form = document.getElementById('resumeForm');
        const formData = new FormData(form);
        const data = {};
        
      
        for (let [key, value] of formData.entries()) {
            if (key.endsWith('[]')) {
                
                const baseKey = key.slice(0, -2);
                if (!data[baseKey]) {
                    data[baseKey] = [];
                }
                data[baseKey].push(value);
            } else {
                
                data[key] = value;
            }
        }
        
       
        if (phoneInput.isValidNumber()) {
            data['phone'] = phoneInput.getNumber();
        } else {
            data['phone'] = document.getElementById('phone').value;
        }
        
       
        data['template'] = document.getElementById('selectedTemplate').value;
        
        return data;
    }

    
    function initializeAutoSave() {
        autoSaveInterval = setInterval(() => {
            if (formChanged) {
                saveDraft();
            }
        }, 10000); 
    }

    function updateAutoSaveStatus(status) {
        const indicator = document.getElementById('autoSaveIndicator');
        const text = document.getElementById('autoSaveText');
        
        indicator.className = 'w-3 h-3 rounded-full auto-save-indicator';
        text.className = 'text-sm font-medium';
        
        switch(status) {
            case 'saving':
                indicator.classList.add('saving');
                text.textContent = 'Saving...';
                text.classList.add('text-yellow-600');
                break;
            case 'saved':
                indicator.classList.add('saved');
                text.textContent = 'Saved';
                text.classList.add('text-green-600');
                lastSaveTime = new Date();
                document.getElementById('lastSaved').textContent = 
                    `Last saved: ${lastSaveTime.toLocaleTimeString()}`;
               
                const autoSaveStatus = document.getElementById('autoSaveStatus');
                autoSaveStatus.classList.remove('hidden');
                setTimeout(() => {
                    autoSaveStatus.classList.add('hidden');
                }, 3000);
                break;
            case 'error':
                indicator.classList.add('error');
                text.textContent = 'Save failed';
                text.classList.add('text-red-600');
                break;
            default:
                indicator.classList.add('bg-gray-400');
                text.textContent = 'Idle';
                text.classList.add('text-gray-600');
        }
    }

   
    function saveDraft() {
        if (!formChanged) return;
        
        updateAutoSaveStatus('saving');
        
        const data = getFormData();
        
       
        localStorage.setItem('resumeDraft', JSON.stringify(data));
        localStorage.setItem('resumeDraftTimestamp', new Date().toISOString());
        
        fetch('{{ route("resume.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                updateAutoSaveStatus('saved');
                formChanged = false;
            } else {
                updateAutoSaveStatus('error');
            }
        })
        .catch(error => {
            updateAutoSaveStatus('error');
            console.error('Auto-save failed:', error);
        });
    }

    function clearDraft() {
        if (confirm('Are you sure you want to clear your current draft?')) {
            localStorage.removeItem('resumeDraft');
            localStorage.removeItem('resumeDraftTimestamp');
            document.getElementById('resumeForm').reset();
            
            
            employmentCounter = 0;
            educationCounter = 0;
            languageCounter = 0;s
            skillCounter = 0;
            
          
            document.getElementById('employmentContainer').innerHTML = '';
            document.getElementById('educationContainer').innerHTML = '';
            document.getElementById('languageContainer').innerHTML = '';
            document.getElementById('skillsContainer').innerHTML = '';
            
            
            document.getElementById('templateDropdown').value = '';
            document.getElementById('selectedTemplate').value = '';
            document.getElementById('templatePreviewInfo').classList.add('hidden');
            
           
            addEmployment();
            addEducation();
            addLanguage();
            addSkill();
            
            formChanged = false;
            updateProgress();
            refreshPreview();
            showMessage('Draft cleared successfully!', 'success');
        }
    }

   
    function loadDraft() {
        const draft = localStorage.getItem('resumeDraft');
        const timestamp = localStorage.getItem('resumeDraftTimestamp');
        
        if (draft) {
            const data = JSON.parse(draft);
            
           
            const draftDate = new Date(timestamp);
            const now = new Date();
            const daysDiff = (now - draftDate) / (1000 * 60 * 60 * 24);
            
            if (daysDiff < 7) {
                if (confirm(`Would you like to load your saved draft from ${draftDate.toLocaleDateString()}?`)) {
                    populateForm(data);
                    showMessage('Draft loaded successfully!', 'success');
                }
            } else {
                
                if (daysDiff < 1) {
                    populateForm(data);
                    showMessage('Auto-loaded recent draft', 'info');
                }
            }
        }
    }

    function populateForm(data) {
       
        document.getElementById('employmentContainer').innerHTML = '';
        document.getElementById('educationContainer').innerHTML = '';
        document.getElementById('languageContainer').innerHTML = '';
        document.getElementById('skillsContainer').innerHTML = '';
        
      
        employmentCounter = 0;
        educationCounter = 0;
        languageCounter = 0;
        skillCounter = 0;
        
        Object.keys(data).forEach(key => {
            if (Array.isArray(data[key])) {
                
                if (key === 'job_title' || key === 'company' || key === 'job_start' || key === 'job_end' || key === 'job_description') {
                    
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('employmentContainer').children.length) {
                            addEmployment();
                        }
                    });
                } else if (key === 'degree' || key === 'school' || key === 'edu_start' || key === 'edu_end' || key === 'edu_description') {
                    
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('educationContainer').children.length) {
                            addEducation();
                        }
                    });
                } else if (key === 'languages' || key === 'language_level') {
                    
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('languageContainer').children.length) {
                            addLanguage();
                        }
                    });
                } else if (key === 'skills' || key === 'skill_level') {
                  
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('skillsContainer').children.length) {
                            addSkill();
                        }
                    });
                }
                
                
                setTimeout(() => {
                    data[key].forEach((value, index) => {
                        const baseName = key.endsWith('[]') ? key.slice(0, -2) : key;
                        const elements = document.querySelectorAll(`[name="${baseName}[]"]`);
                        if (elements[index]) {
                            elements[index].value = value;
                        }
                    });
                    updateProgress();
                    refreshPreview();
                }, 100);
            } else {
                const element = document.querySelector(`[name="${key}"]`);
                if (element) {
                    element.value = data[key];
                }
            }
        });
        
       
        if (data.phone && phoneInput) {
            phoneInput.setNumber(data.phone);
        }
        
       
        if (data.template) {
            selectTemplate(data.template);
            
            document.getElementById('templateDropdown').value = data.template;
        }
        
        updateProgress();
        refreshPreview();
    }

   
    function toggleAdditional() {
        const section = document.getElementById('additionalDetails');
        const icon = document.getElementById('additionalIcon');
        const text = document.getElementById('additionalText');
        
        section.classList.toggle('hidden');
        if (section.classList.contains('hidden')) {
            icon.textContent = '+';
            text.textContent = 'Show Additional Details';
        } else {
            icon.textContent = '-';
            text.textContent = 'Hide Additional Details';
        }
        updateProgress();
        refreshPreview();
    }

   
    function selectTemplate(templateName) {
        if (!templateName) return;
        
        document.getElementById('selectedTemplate').value = templateName;
        
       
        const templateNames = {
            'template1': 'Professional Blue',
            'template2': 'Modern Black',
            'template3': 'Creative Green'
        };
        
        const templateDescriptions = {
            'template1': 'Clean and professional design with blue accents',
            'template2': 'Contemporary design with dark accents',
            'template3': 'Fresh and creative design with green theme'
        };
        
        document.getElementById('currentTemplateName').textContent = templateNames[templateName];
        document.getElementById('templateDescription').textContent = templateDescriptions[templateName];
        
      
        document.getElementById('templatePreviewInfo').classList.remove('hidden');
        
        refreshPreview();
        showMessage(`Template selected: ${templateNames[templateName]}`, 'success');
    }

    const debouncedPreviewUpdate = debounce(refreshPreview, 1000);

    function refreshPreview() {
        const data = getFormData();
        const template = document.getElementById('selectedTemplate').value;
        
        
        if (!template) {
            document.getElementById('livePreview').innerHTML = `
                <div class="text-center text-gray-500 py-20">
                    <div class="text-4xl mb-4">📝</div>
                    <p class="text-lg font-medium">Please select a template to see preview</p>
                </div>
            `;
            return;
        }
        
        fetch('{{ route("resume.preview") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            document.getElementById('livePreview').innerHTML = html;
            document.getElementById('livePreview').classList.add('fade-in');
        })
        .catch(error => {
            console.error('Preview update failed:', error);
            
        });
    }

   
    function updateProgress() {
        const inputs = document.querySelectorAll('input, textarea, select');
        let filled = 0, total = 0;
        
        inputs.forEach(i => {
            if (i.offsetParent !== null && i.classList.contains('required-field')) {
                total++;
                if (i.type === 'select-one') {
                    if (i.value !== '') filled++;
                } else if (i.type === 'tel') {
                    if (phoneInput.isValidNumber()) filled++;
                } else {
                    if (i.value.trim() !== '') filled++;
                }
            }
        });
        
        const percent = Math.round((filled / total) * 100);
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressText').innerText = percent + '% Complete';
        
     
        const progressBar = document.getElementById('progressBar');
        progressBar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500', 'bg-blue-600');
        
        if (percent < 30) {
            progressBar.classList.add('bg-red-500');
        } else if (percent < 70) {
            progressBar.classList.add('bg-yellow-500');
        } else {
            progressBar.classList.add('bg-green-500');
        }
    }

   
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function showMessage(message, type = 'info') {
        const container = document.getElementById('messageContainer');
        const colors = {
            success: 'bg-green-100 border-green-400 text-green-700',
            error: 'bg-red-100 border-red-400 text-red-700',
            info: 'bg-blue-100 border-blue-400 text-blue-700'
        };
        
        container.className = `${colors[type]} border-l-4 p-4 rounded-lg`;
        container.innerHTML = message;
        container.classList.remove('hidden');
        
        setTimeout(() => {
            container.classList.add('hidden');
        }, 5000);
    }

  
    function validateForm() {
        let isValid = true;
        const requiredFields = document.querySelectorAll('.required-field');
        let emptyFields = [];

        requiredFields.forEach(field => {
            if (field.type === 'select-one') {
                if (field.value === '') {
                    isValid = false;
                    emptyFields.push(field.name || field.previousElementSibling?.textContent || 'Field');
                }
            } else if (field.type === 'tel') {
                if (!phoneInput.isValidNumber()) {
                    isValid = false;
                    emptyFields.push('Phone Number');
                }
            } else {
                if (field.value.trim() === '') {
                    isValid = false;
                    emptyFields.push(field.name || field.previousElementSibling?.textContent || 'Field');
                }
            }
        });

        if (!isValid) {
            showMessage(`Please fill all required fields before downloading. Missing: ${emptyFields.slice(0, 3).join(', ')}${emptyFields.length > 3 ? '...' : ''}`, 'error');
            return;
        }

        
        const selectedTemplate = document.getElementById('selectedTemplate').value;
        if (!selectedTemplate) {
            showMessage('Please select a template before downloading.', 'error');
            return;
        }

       
        if (phoneInput.isValidNumber()) {
            document.getElementById('fullPhone').value = phoneInput.getNumber();
        }

        showMessage('Generating your resume PDF...', 'info');
        document.getElementById('resumeForm').submit();
    }

  
    function addEmployment() {
        const container = document.getElementById('employmentContainer');
        employmentCounter++;
        const index = employmentCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg employment-item">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold text-gray-700">Job #${index}</h4>
                    <button type="button" onclick="removeEmployment(this)" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                        <input type="text" name="job_title[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text" name="company[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="month" name="job_start[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="month" name="job_end[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Description and Responsibilities</label>
                    <textarea name="job_description[]" class="w-full p-2 bg-blue-50 border border-blue-200 rounded required-field" oninput="handleInputChange()"></textarea>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeEmployment(button) {
        button.closest('.employment-item').remove();
        updateProgress();
        refreshPreview();
    }

   
    function addEducation() {
        const container = document.getElementById('educationContainer');
        educationCounter++;
        const index = educationCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg education-item">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold text-gray-700">Education #${index}</h4>
                    <button type="button" onclick="removeEducation(this)" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Degree/Certificate</label>
                        <input type="text" name="degree[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">School/University</label>
                        <input type="text" name="school[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="month" name="edu_start[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="month" name="edu_end[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description of Studies</label>
                    <textarea name="edu_description[]" class="w-full p-2 bg-blue-50 border border-blue-200 rounded required-field" oninput="handleInputChange()"></textarea>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeEducation(button) {
        button.closest('.education-item').remove();
        updateProgress();
        refreshPreview();
    }

    
    function addLanguage() {
        const container = document.getElementById('languageContainer');
        languageCounter++;
        const index = languageCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg language-item">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold text-gray-700">Language #${index}</h4>
                    <button type="button" onclick="removeLanguage(this)" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                        <select name="languages[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
                            <option value="">Select Language</option>
                             @include('partials.language-options')
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency</label>
                        <select name="language_level[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
                            <option value="">Select Proficiency</option>
                            <option value="Native">Native</option>
                            <option value="Fluent">Fluent</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Basic">Basic</option>
                        </select>
                    </div>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeLanguage(button) {
        button.closest('.language-item').remove();
        updateProgress();
        refreshPreview();
    }

    
    function addSkill() {
        const container = document.getElementById('skillsContainer');
        skillCounter++;
        const index = skillCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg skill-item">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold text-gray-700">Skill #${index}</h4>
                    <button type="button" onclick="removeSkill(this)" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill</label>
                        <input type="text" name="skills[]" placeholder="e.g., JavaScript, Project Management" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                        <select name="skill_level[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" onchange="handleInputChange()">
                            <option value="">Select Level</option>
                            <option value="Expert">Expert</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Beginner">Beginner</option>
                        </select>
                    </div>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeSkill(button) {
        button.closest('.skill-item').remove();
        updateProgress();
        refreshPreview();
    }
    function refreshPreview() {
   const data = getFormData();
   const template = document.getElementById('selectedTemplate').value;
   
   if (!template) {
       document.getElementById('livePreview').innerHTML = `
           <div class="text-center text-gray-500 py-20">
               <div class="text-4xl mb-4">📝</div>
               <p class="text-lg font-medium">Please select a template to see preview</p>
           </div>
       `;
       return;
   }
   
   fetch('{{ route("resume.preview") }}', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': '{{ csrf_token() }}'
       },
       body: JSON.stringify(data)
   })
   .then(response => {
       if (!response.ok) throw new Error('Network response was not ok');
       return response.text();
   })
   .then(html => {
      
       const parser = new DOMParser();
       const doc = parser.parseFromString(html, 'text/html');
       
      
       const styles = doc.querySelectorAll('style');
       let styleContent = '';
       styles.forEach(style => {
           styleContent += style.textContent;
       });
       const bodyContent = doc.body.innerHTML;
       const wrappedContent = `<div class="template-content">${bodyContent}</div>`;
       const scopedStyles = scopeCss(styleContent, '.template-content');
       document.getElementById('livePreview').innerHTML = wrappedContent;
       const existingStyle = document.getElementById('livePreviewStyle');
       if (existingStyle) {
           existingStyle.remove();
       }
       const styleTag = document.createElement('style');
       styleTag.id = 'livePreviewStyle';
       styleTag.textContent = scopedStyles;
       document.getElementById('livePreview').appendChild(styleTag);
       
       document.getElementById('livePreview').classList.add('fade-in');
   })
   .catch(error => {
       console.error('Preview update failed:', error);
   });
}

function scopeCss(css, scope) {
   let scopedCss = '';
   const rules = css.split('}');
   rules.forEach(rule => {
       if (rule.trim() === '') return;
       if (rule.startsWith('@')) {
           const parts = rule.split('{');
           if (parts.length === 2) {
               scopedCss += parts[0] + '{' + scopeCss(parts[1], scope) + '}';
           } else {
               scopedCss += rule + '}';
           }
       } else {
          
           const parts = rule.split('{');
           if (parts.length === 2) {
               const selectors = parts[0].split(',').map(selector => {
                   return scope + ' ' + selector.trim();
               }).join(', ');
               scopedCss += selectors + '{' + parts[1] + '}';
           } else {
               scopedCss += rule + '}';
           }
       }
   });
   
   return scopedCss;
}
  </script>
</body>
</html>