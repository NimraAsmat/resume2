<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Build</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <main class="max-w-4xl mx-auto mt-8 bg-white shadow-lg p-6">

    
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Resume Progress</h2>
      <div class="w-full bg-gray-200 h-1.5">
        <div id="progressBar" class="bg-blue-600 h-1.5" style="width:0%"></div>
      </div>
      <div class="flex justify-between text-sm text-gray-500 mt-1">
        <span>Get Started</span>
        <span id="progressText">0% Complete</span>
      </div>
    </div>

   
    <form method="POST" action="<?php echo e(route('resume.download')); ?>" id="resumeForm">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="template" id="selectedTemplate" value="template1">

     
      <section class="space-y-4">
        <h3 class="text-xl font-semibold pb-1">Personal Details</h3>
        <p class="text-gray-600 text-sm">Enter your basic personal information, such as your name, contact details, and nationality. This information will be displayed at the top of your resume.</p>
        <div class="grid grid-cols-2 gap-4">
          <input type="text" name="first_name" placeholder="First Name" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          <input type="text" name="last_name" placeholder="Last Name" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
        </div>
        <div class="grid grid-cols-2 gap-4">
          <input type="email" name="email" placeholder="Email" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          <input type="text" name="phone" placeholder="Phone" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
        </div>
        <div class="grid grid-cols-2 gap-4">
          <input type="text" name="occupation" placeholder="Occupation" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          <input type="text" name="country" placeholder="Country" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
        </div>
        <div class="grid grid-cols-2 gap-4">
          <input type="date" name="dob" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          <input type="text" name="nationality" placeholder="Nationality" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
        </div>
        <select name="gender" class="p-2 w-full bg-blue-100 border-0 required-field" oninput="updateProgress()">
          <option value="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </section>

    
      <section id="additionalDetails" class="space-y-4 mt-6 hidden">
        <h3 class="text-xl font-semibold pb-1">Additional Details</h3>
        <p class="text-gray-600 text-sm">Include hobbies, interests, or personal achievements that give a broader view of your personality.</p>
        <textarea name="hobbies" class="w-full p-3 bg-blue-100 border-0 additional-field" placeholder="Hobbies" oninput="updateProgress()"></textarea>
        <textarea name="interests" class="w-full p-3 bg-blue-100 border-0 additional-field" placeholder="Interests" oninput="updateProgress()"></textarea>
      </section>

      <div class="text-center my-6">
        <button type="button" onclick="toggleAdditional(event)" class="px-6 py-2 font-bold border border-black bg-white">
          <span class="text-blue-600">+</span> Show Additional Details
        </button>
      </div>

      
      <section class="space-y-3">
        <h3 class="text-xl font-semibold pb-1">Professional Summary</h3>
        <p class="text-gray-600 text-sm">Provide a brief overview of your professional background, expertise, and career objectives.</p>
        <textarea name="summary" class="w-full p-3 h-24 bg-blue-100 border-0 required-field" placeholder="Enter professional summary..." oninput="updateProgress()"></textarea>
      </section>

    
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Employment History</h3>
        <p class="text-gray-600 text-sm">List your previous jobs in reverse chronological order. Include your role, company, duration, and key responsibilities.</p>
        <div id="employmentContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addEmployment()" class="px-4 py-2 font-bold border border-black bg-white mt-2">
            <span class="text-blue-600">+</span> Add Job
          </button>
        </div>
      </section>

     
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Education</h3>
        <p class="text-gray-600 text-sm">Enter your academic qualifications, including degrees, certifications, and institutions attended.</p>
        <div id="educationContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addEducation()" class="px-4 py-2 font-bold border border-black bg-white mt-2">
            <span class="text-blue-600">+</span> Add Education
          </button>
        </div>
      </section>

     
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Languages</h3>
        <p class="text-gray-600 text-sm">List the languages you know and your proficiency in each.</p>
        <div id="languageContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addLanguage()" class="px-4 py-2 font-bold border border-black bg-white mt-2">
            <span class="text-blue-600">+</span> Add Language
          </button>
        </div>
      </section>

     
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Skills</h3>
        <p class="text-gray-600 text-sm">Include key skills, technical abilities, and tools you are proficient in.</p>
        <div id="skillsContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addSkill()" class="px-4 py-2 font-bold border border-black bg-white mt-2">
            <span class="text-blue-600">+</span> Add Skill
          </button>
        </div>
      </section>

   
      <div class="text-center mt-8 flex justify-center gap-4">
        <button type="button" onclick="validateForm()" class="px-8 py-3 rounded-none font-bold text-lg bg-blue-600 text-white border-0">Download</button>
        <div class="relative">
          <button type="button" class="px-8 py-3 font-bold border border-black bg-white" onclick="toggleTemplateOptions()">Select Template</button>
          <div id="templateOptions" class="absolute left-0 mt-1 bg-white border border-black w-full hidden z-10">
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-gray-100" onclick="selectTemplate('template1')">Template 1</button>
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-gray-100" onclick="selectTemplate('template2')">Template 2</button>
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-gray-100" onclick="selectTemplate('template3')">Template 3</button>
          </div>
        </div>
      </div>

      <div id="templatePreview" class="text-center mt-6 text-sm text-gray-600"></div>
    </form>
  </main>

 
  <script>
    function toggleTemplateOptions() {
      document.getElementById('templateOptions').classList.toggle('hidden');
    }

    function selectTemplate(templateName) {
      document.getElementById('selectedTemplate').value = templateName;
      document.getElementById('templateOptions').classList.add('hidden');
      updateTemplatePreview(templateName);
    }

    function updateTemplatePreview(templateName) {
      const preview = document.getElementById('templatePreview');
      let html = '';
      if (templateName === 'template1') html = 'Selected Template: <b>Professional Blue</b>';
      else if (templateName === 'template2') html = 'Selected Template: <b>Modern Black</b>';
      else if (templateName === 'template3') html = 'Selected Template: <b>Creative Green</b>';
      preview.innerHTML = html;
    }

    function updateProgress() {
      const inputs = document.querySelectorAll('input, textarea, select');
      let filled = 0, total = 0;
      inputs.forEach(i => {
        if (i.offsetParent !== null) {
          total++;
          if (i.value.trim() !== '') filled++;
        }
      });
      const percent = Math.round((filled / total) * 100);
      document.getElementById('progressBar').style.width = percent + '%';
      document.getElementById('progressText').innerText = percent + '% Complete';
    }

    function toggleAdditional(event) {
      const section = document.getElementById('additionalDetails');
      const btn = event.currentTarget;
      section.classList.toggle('hidden');
      btn.innerHTML = section.classList.contains('hidden')
        ? '<span class="text-blue-600">+</span> Show Additional Details'
        : '<span class="text-blue-600">-</span> Hide Additional Details';
      updateProgress();
    }

    function addEmployment() {
      const container = document.getElementById('employmentContainer');
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-2 border-b pb-2">
          <div class="grid grid-cols-2 gap-4">
            <input type="text" name="job_title[]" placeholder="Job Title" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
            <input type="text" name="company[]" placeholder="Company" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <input type="month" name="job_start[]" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
            <input type="month" name="job_end[]" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          </div>
          <textarea name="job_description[]" class="w-full p-2 bg-blue-100 border-0 required-field" placeholder="Job Description" oninput="updateProgress()"></textarea>
        </div>
      `);
    }

    function addEducation() {
      const container = document.getElementById('educationContainer');
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-2 border-b pb-2">
          <div class="grid grid-cols-2 gap-4">
            <input type="text" name="degree[]" placeholder="Degree" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
            <input type="text" name="school[]" placeholder="School/University" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <input type="month" name="edu_start[]" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
            <input type="month" name="edu_end[]" class="p-2 bg-blue-100 border-0 required-field" oninput="updateProgress()">
          </div>
          <textarea name="edu_description[]" class="w-full p-2 bg-blue-100 border-0 required-field" placeholder="Education Description" oninput="updateProgress()"></textarea>
        </div>
      `);
    }

    function addLanguage() {
      document.getElementById('languageContainer').insertAdjacentHTML('beforeend', `
        <input type="text" name="languages[]" placeholder="Language" class="mt-2 p-2 w-full bg-blue-100 border-0 required-field" oninput="updateProgress()">
      `);
    }

    function addSkill() {
      document.getElementById('skillsContainer').insertAdjacentHTML('beforeend', `
        <input type="text" name="skills[]" placeholder="Skill" class="mt-2 p-2 w-full bg-blue-100 border-0 required-field" oninput="updateProgress()">
      `);
    }

    function validateForm() {
      const requiredFields = document.querySelectorAll('.required-field, .additional-field');
      let allFilled = true;
      requiredFields.forEach(f => {
        if (f.offsetParent !== null && f.value.trim() === '') allFilled = false;
      });
      if (!allFilled) alert("Please fill all required fields before downloading.");
      else document.getElementById('resumeForm').submit();
    }
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\resume2\resources\views/resume.blade.php ENDPATH**/ ?>