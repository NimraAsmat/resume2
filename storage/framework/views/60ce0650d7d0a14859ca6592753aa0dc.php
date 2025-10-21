<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - <?php echo e($first_name ?? ''); ?> <?php echo e($last_name ?? ''); ?></title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            line-height: 1.6; 
            color: #000; 
            padding: 40px;
            margin: 0;
            background: #fff; 
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff; 
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }

        h1 { 
            color: #2563eb; 
            font-size: 36px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        h3 {
            color: #2563eb; 
            font-size: 20px;
            border-bottom: 1px solid #2563eb;
            padding-bottom: 5px;
            margin-top: 20px; 
            margin-bottom: 12px; 
        }

        p, li {
            font-size: 16px;
        }

        .contact-info {
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 25px; 
        }

        .contact-info ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0;
        }

        .contact-info li {
            margin-bottom: 8px;
        }

        .section {
            margin-bottom: 15px; 
        }

        .job-item, .edu-item {
            margin-bottom: 15px; 
            padding-bottom: 12px; 
            
        }

        .job-header, .edu-header {
            display: block;
            margin-bottom: 6px; 
        }

        .job-title, .edu-degree {
            font-weight: bold;
            color: #1e40af;
            font-size: 18px;
        }

        .company, .school {
            font-style: italic;
            color: #4b5563;
            font-size: 16px;
            margin-left: 5px;
        }

        .date {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
            margin-top: 5px; 
        }

        .job-description, .edu-description {
            margin-top: 8px; 
            color: #374151;
        }

        ul.skills, ul.languages {
            padding-left: 20px;
            list-style-type: disc;
            margin-top: 8px; 
        }

        .footer {
            margin-top: 30px; 
            color: #666;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo e($first_name ?? 'First Name'); ?> <?php echo e($last_name ?? 'Last Name'); ?></h1>
        
        <div class="contact-info">
            <ul>
                <li><strong>Email:</strong> <?php echo e($email ?? 'N/A'); ?></li>
                <li><strong>Phone:</strong> <?php echo e($phone ?? 'N/A'); ?></li>
                <li><strong>Occupation:</strong> <?php echo e($occupation ?? 'N/A'); ?></li>
                <?php if(!empty($country)): ?>
                    <li><strong>Country:</strong> <?php echo e($country); ?></li>
                <?php endif; ?>
                <?php if(!empty($nationality)): ?>
                    <li><strong>Nationality:</strong> <?php echo e($nationality); ?></li>
                <?php endif; ?>
                <?php if(!empty($dob)): ?>
                    <li><strong>Date of Birth:</strong> <?php echo e(\Carbon\Carbon::parse($dob)->format('F j, Y')); ?></li>
                <?php endif; ?>
                <?php if(!empty($gender)): ?>
                    <li><strong>Gender:</strong> <?php echo e($gender); ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <?php if(!empty($summary)): ?>
        <div class="section">
            <h3>Professional Summary</h3>
            <p><?php echo e($summary); ?></p>
        </div>
        <?php endif; ?>

        <?php if(!empty($job_title) && count($job_title) > 0): ?>
        <div class="section">
            <h3>Employment History</h3>
            <?php $__currentLoopData = $job_title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="job-item">
                <div class="job-header">
                    <div>
                        <span class="job-title"><?php echo e($title ?? 'Job Title'); ?></span>
                        <span class="company">at <?php echo e($company[$index] ?? ''); ?></span>
                    </div>
                    <div class="date">
                        <?php echo e($job_start[$index] ?? ''); ?> 
                        <?php if(!empty($job_start[$index]) && !empty($job_end[$index])): ?> - <?php endif; ?> 
                        <?php echo e($job_end[$index] ?? ''); ?>

                    </div>
                </div>
                <?php if(!empty($job_description[$index])): ?>
                <div class="job-description"><?php echo e($job_description[$index]); ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($degree) && count($degree) > 0): ?>
        <div class="section">
            <h3>Education</h3>
            <?php $__currentLoopData = $degree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $deg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="edu-item">
                <div class="edu-header">
                    <div>
                        <span class="edu-degree"><?php echo e($deg ?? 'Degree'); ?></span>
                        <span class="school">at <?php echo e($school[$index] ?? ''); ?></span>
                    </div>
                    <div class="date">
                        <?php echo e($edu_start[$index] ?? ''); ?> 
                        <?php if(!empty($edu_start[$index]) && !empty($edu_end[$index])): ?> - <?php endif; ?> 
                        <?php echo e($edu_end[$index] ?? ''); ?>

                    </div>
                </div>
                <?php if(!empty($edu_description[$index])): ?>
                <div class="edu-description"><?php echo e($edu_description[$index]); ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($skills) && count($skills) > 0): ?>
        <div class="section">
            <h3>Skills</h3>
            <ul class="skills">
                <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($skill); ?> <?php if(!empty($skill_level[$index])): ?> (<?php echo e($skill_level[$index]); ?>) <?php endif; ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if(!empty($languages) && count($languages) > 0): ?>
        <div class="section">
            <h3>Languages</h3>
            <ul class="languages">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($lang); ?> <?php if(!empty($language_level[$index])): ?> (<?php echo e($language_level[$index]); ?>) <?php endif; ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if(!empty($hobbies) || !empty($interests)): ?>
        <div class="section">
            <h3>Additional Information</h3>
            <?php if(!empty($hobbies)): ?>
                <p><strong>Hobbies:</strong> <?php echo e($hobbies); ?></p>
            <?php endif; ?>
            <?php if(!empty($interests)): ?>
                <p><strong>Interests:</strong> <?php echo e($interests); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="footer">
            Generated on: <?php echo e(date('F j, Y')); ?>

        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\resume2\resources\views/templates/template1.blade.php ENDPATH**/ ?>