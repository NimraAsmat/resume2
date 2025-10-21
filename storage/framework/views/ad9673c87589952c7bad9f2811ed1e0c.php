<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Resume - <?php echo e($first_name ?? ''); ?> <?php echo e($last_name ?? ''); ?></title>
    <style>
        body {
            font-family: Calibri, Arial, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 40px 50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .header h1 {
            font-family: "Times New Roman", serif;
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            color: #000;
        }

        .header p.profession {
            font-family: "Times New Roman", serif;
            font-size: 20px;
            margin: 5px 0 10px 0;
            color: #555;
        }

        .header .contact {
            font-size: 14px;
            color: #555;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000; 
        }

        .section {
            margin-top: 25px;
        }

        .job-item, .edu-item {
            background: #f9f9f9;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            border-left: 3px solid #000;
        }

        .job-header, .edu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .job-title, .edu-degree {
            font-weight: bold;
            font-size: 16px;
            color: #000;
            display: inline;
        }

        .company, .school {
            font-weight: bold;
            color: #333;
            margin-left: 5px;
            display: inline;
        }

        .date {
            font-size: 14px;
            color: #555;
            white-space: nowrap;
        }

        .job-item p, .edu-item p {
            margin-top: 8px;
            font-size: 15px;
            color: #333;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 40px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo e($first_name ?? 'First Name'); ?> <?php echo e($last_name ?? 'Last Name'); ?></h1>
            <p class="profession"><?php echo e($occupation ?? 'Professional'); ?></p>
            <div class="contact">
                <?php echo e($email ?? ''); ?>

                <?php if(!empty($email) && !empty($phone)): ?> | <?php endif; ?>
                <?php echo e($phone ?? ''); ?>

                <?php if((!empty($email) || !empty($phone)) && !empty($country)): ?> | <?php endif; ?>
                <?php echo e($country ?? ''); ?>

                <?php if(!empty($nationality)): ?> | <?php echo e($nationality); ?> <?php endif; ?>
            </div>
        </div>

        <?php if(!empty($summary)): ?>
        <div class="section">
            <div class="section-title">Professional Summary</div>
            <p><?php echo e($summary); ?></p>
        </div>
        <?php endif; ?>

        <?php if(!empty($job_title) && count($job_title) > 0): ?>
        <div class="section">
            <div class="section-title">Work Experience</div>
            <?php $__currentLoopData = $job_title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="job-item">
                <div class="job-header">
                    <div>
                        <span class="job-title"><?php echo e($title ?? 'Job Title'); ?></span>
                        <?php if(!empty($company[$index])): ?>
                        <span class="company">at <?php echo e($company[$index]); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="date">
                        <?php echo e($job_start[$index] ?? ''); ?> 
                        <?php if(!empty($job_start[$index]) && !empty($job_end[$index])): ?> – <?php endif; ?> 
                        <?php echo e($job_end[$index] ?? ''); ?>

                    </div>
                </div>
                <?php if(!empty($job_description[$index])): ?>
                <p><?php echo e($job_description[$index]); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($degree) && count($degree) > 0): ?>
        <div class="section">
            <div class="section-title">Education</div>
            <?php $__currentLoopData = $degree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $deg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="edu-item">
                <div class="edu-header">
                    <div>
                        <span class="edu-degree"><?php echo e($deg ?? 'Degree'); ?></span>
                        <?php if(!empty($school[$index])): ?>
                        <span class="school">at <?php echo e($school[$index]); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="date">
                        <?php echo e($edu_start[$index] ?? ''); ?> 
                        <?php if(!empty($edu_start[$index]) && !empty($edu_end[$index])): ?> – <?php endif; ?> 
                        <?php echo e($edu_end[$index] ?? ''); ?>

                    </div>
                </div>
                <?php if(!empty($edu_description[$index])): ?>
                <p><?php echo e($edu_description[$index]); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if((!empty($skills) && count($skills) > 0) || (!empty($languages) && count($languages) > 0)): ?>
        <div class="section">
            <div class="grid-2">
                <?php if(!empty($skills) && count($skills) > 0): ?>
                <div>
                    <div class="section-title">Skills</div>
                    <ul>
                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($skill); ?> <?php if(!empty($skill_level[$index])): ?> (<?php echo e($skill_level[$index]); ?>) <?php endif; ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if(!empty($languages) && count($languages) > 0): ?>
                <div>
                    <div class="section-title">Languages</div>
                    <ul>
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($lang); ?> <?php if(!empty($language_level[$index])): ?> (<?php echo e($language_level[$index]); ?>) <?php endif; ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($hobbies) || !empty($interests)): ?>
        <div class="section">
            <div class="section-title">Additional Details</div>
            <?php if(!empty($hobbies)): ?>
            <p><strong>Hobbies:</strong> <?php echo e($hobbies); ?></p>
            <?php endif; ?>
            <?php if(!empty($interests)): ?>
            <p><strong>Interests:</strong> <?php echo e($interests); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($dob) || !empty($gender)): ?>
        <div class="section">
            <div class="section-title">Personal Information</div>
            <?php if(!empty($dob)): ?>
            <p><strong>Date of Birth:</strong> <?php echo e(\Carbon\Carbon::parse($dob)->format('F j, Y')); ?></p>
            <?php endif; ?>
            <?php if(!empty($gender)): ?>
            <p><strong>Gender:</strong> <?php echo e($gender); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="footer">
            Generated on: <?php echo e(date('F j, Y')); ?>

        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\resume2\resources\views/templates/template2.blade.php ENDPATH**/ ?>