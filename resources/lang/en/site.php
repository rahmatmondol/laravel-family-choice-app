<?php

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;

return [
  'The selected phone is invalid.' => 'The selected phone is invalid.',
  'The email or phone field is required.' => 'The email or phone field is required.',
  'Password not correct' => 'Password not correct',
  'User not found' => 'User not found',
  'User already verified' => 'User already verified',
  'Successfully logged out' => 'Successfully logged out',
  'Unauthenticated' => 'Unauthenticated',
  'Old password not correct' => 'Old password not correct',
  'Confirm the phone first.' => 'Confirm the phone first.',
  'User not verified' => 'User not verified',
  'you can not review this school' => 'you can not review this school',
  'reservation_status' => [
    ReservationStatus::Pending->value => 'Pending',
    ReservationStatus::Accepted->value => 'Accepted',
    ReservationStatus::Rejected->value => 'Rejected',
    'Status' =>"Reservation Status",
  ],
  'payment_status' => [
    PaymentStatus::Pending->value => 'Pending',
    PaymentStatus::Succeeded->value => 'Succeeded',
    PaymentStatus::Failed->value => 'Failed',
    PaymentStatus::Refunded->value => 'Refunded',
    'Status' =>"Payment Status",

  ],
  'this course not related to current school' => 'this course not related to current school',
  'this child not related to current reservation' => 'this child not related to current reservation',
  'pending_reservation_body' => 'The reservation has been successfully booked, and the data and attachments will be reviewed by the school administration and contact you as soon as possible',
  'accepted_reservation_body' => 'The reservation data has been approved by the school administration. You can make the payment now to complete the reservation process',
  'rejected_reservation_body' => '',
  'Total' => 'Total',
  'Dashboard' => 'Dashboard',
  'Home' => 'Home',
  'Number Of Reservations' => 'Number Of Reservations',
  'More info' => 'More info',
  'Number Of Pending Reservations' => 'Number Of Pending Reservations',
  'Number Of Schools' => 'Number Of Schools',
  'Number Of courses' => 'Number Of courses',
  'Number Of Grades' => 'Number Of Grades',
  'Number Of Services' => 'Number Of Services',
  'Latest Members' => 'Latest Members',
  'List Customers' => 'List Customers',
  'Sales Graph' => 'Sales Graph',
  '8 New Members' => '8 New Members',
  'Number Of Customers' => 'Number Of Customers',
  'Roles' => 'Roles',
  'Search' => 'Search',
  'Add' => 'Add',
  'Edit' => 'Edit',
  'Delete' => 'Delete',
  'View' => 'View',
  'Active' => 'Active',
  'In-Active' => 'In-Active',
  'No Data Found' => 'No Data Found',
  'Status' => 'Status',
  'search' => 'search',
  'Show Role' => 'Show Role',
  'Name' => 'Name',
  'Permissions' => 'Permissions',
  'Model' => 'Model',
  'Edit Role' => 'Edit Role',
  'Save' => 'Save',
  'Save & Continue' => 'Save & Continue',
  'Admins' => 'Admins',
  'Full Name' => 'Full Name',
  'Image' => 'Image',
  'E-mail' => 'E-mail',
  'First Name' => 'First Name',
  'Last Name' => 'Last Name',
  'E-mail' => 'E-mail',
  'Create new role' => 'Create new role',
  'Password Confirmation' => 'Password Confirmation',
  'Password' => 'Password',
  'Create Admin' => 'Create Admin',
  'Show Admin' => 'Show Admin',
  'Edit Admin' => 'Edit Admin',
  'Customers' => 'Customers',
  'Verified' => 'Verified',
  'Not Verified' => 'Not Verified',
  'Phone' => 'Phone',
  'Show Customer' => 'Show Customer',
  'Date of birth' => 'Date of birth',
  'Edit Customer' => 'Edit Customer',
  'Male' => 'Male',
  'Female' => 'Female',
  'Gender' => 'Gender',
  'Parent Name' => 'Parent Name',
  'School' => 'School',
  'Customer' => 'Customer',
  'Reservations' => 'Reservations',
  'Order Item' => 'Order Item',
  'Title' => 'Title',
  'SchoolTypes' => 'School Types',
  'Types' => 'Types',
  'Show Type' => 'Show Type',
  'Schools' => 'Schools',
  'Grades' => 'Grades',
  'Address' => 'Address',
  'Description' => 'Description',
  'Type' => 'Type',
  'Fees' => 'Fees',
  'Cover' => 'Cover Photo',
  'Attachments' => 'Attachments',
  'Available Seats' => 'Available Seats',
  'Show school' => 'Show school',
  'EducationalSubjects' => 'Educational Subjects',
  'EducationTypes' => 'Education Types',
  'schoolTypes' => 'School Types',
  'Available seats' => 'Available seats',
  'Total seats' => 'Total seats',
  'Whatsapp' => 'Whatsapp',
  'Services' => 'Services',
  'Create School' => 'Create School',
  'Edit School' => 'Edit School',
  'Edit EducationalSubject' => 'Edit Educational Subject',
  'Show EducationalSubject' => 'Show Educational Subject',
  'Show EducationType' => 'Show Education Type',
  'Edit EducationType' => 'Edit Education Type',
  'Show SchoolType' => 'Show School Type',
  'Edit SchoolType' => 'Edit School Type',
  'Edit Service' => 'Edit Service',
  'Create Service' => 'Create Service',
  'Show Service' => 'Show Service',
  'Create Grade' => 'Create Grade',
  'Show Grade' => 'Show Grade',
  'Edit Grade' => 'Edit Grade',
  'From Date' => 'From Date',
  'To Date' => 'To Date',
  'Confirm operation' => 'Confirm operation',
  'yes' => 'yes',
  'no' => 'no',
  'Courses' => 'Courses',
  'Create Course' => 'Create Course',
  'Create new school' => 'Create new school',
  'Show Course' => 'Show Course',
  'Edit Course' => 'Edit Course',
  'Create Role' => 'Create Role',
  'First Name' => 'First Name',
  'Create Customer' => 'Create Customer',
  'Create Type' => 'Create Type',
  'Create EducationalSubject' => 'Create Educational Subject',
  'Create EducationType' => 'Create Education Type',
  'Create SchoolType' => 'Create School Type',
  'Cities' => 'Cities',
  'Create City' => 'Create City',
  'Edit City' => 'Edit City',
  'Show City' => 'Show City',
  'Sliders' => 'Sliders',
  'Edit Slider' => 'Edit Slider',
  'Show Slider' => 'Show Slider',
  'Link' => 'Link',
  'Create Slider' => 'Create Slider',
  'User Manuals' => 'User Manuals',
  'User_manuals' => 'User Manual',
  'Create User Manual' => 'Create User Manual',
  'Show User Manual' => 'Show User Manual',
  'Edit User Manual' => 'Edit User Manual',
  'Show Attachment' => 'Show Attachment',
  'Edit Attachment' => 'Edit Attachment',
  'Template File' => 'Template File',
  'Create Attachment' => 'Create Attachment',
  'Logout' => 'Logout',
  'Version' => 'Version',
  'Copyright' => 'Copyright',
  'All rights reserved.' => 'All rights reserved.',
  'Sign in to start your session' => 'Sign in to start your session',
  'Login' => 'Login',
  'Sign In' => 'Sign In',
  'Remember Me' => 'Remember Me',
  'Total Fees' => 'Total Fees',
  'Identification Number' => 'Identification Number',
  'Reservation Details' => 'Reservation Details',
  'Student Details' => 'Student Details',
  'Child Name' => 'Child Name',
  'Administrative Expenses' => 'Administrative Expenses',
  'Download' => 'Download',
  'Show Reservation' => 'Show Reservation',
  'Grade' => 'Grade',
  'Summery' => 'Summery',
  'Wintry' => 'Wintry',
  'Course' => 'Course',
  'Edit Reservation' => 'Edit Reservation',
  'Reason of refuse' => 'Reason of refuse',
  'Data added successfully' => 'Data added successfully',
  'Profile' => 'Profile',
  'Edit Profile' => 'Edit Profile',
  'Confirm Delete' => 'Confirm Delete',
  'Data deleted successfully' => 'Data deleted successfully',
  'Your current password does not matches with the password.' => 'Your current password does not matches with the password.',
  'Password successfully changed!' => 'Password successfully changed!',
  'Old Password' => 'Old Password',
  'Current Password' => 'Current Password',
  'Change Password' => 'Change Password',
  'List Reservations' => 'List Reservations',
  '8 New Reservations' => '8 New Reservations',
  'Latest Reservations' => 'Latest Reservations',
  'Select All' => 'Select All',
  'Deselect All' => 'Deselect All',
  'Verification' => 'Verification',
  'Created At' => 'Created At',
  'Actions' => 'Actions',
  'Export' => 'Export',
  'User Deleted' => 'User Deleted',
  'Parent Date Of Birth' => 'Date Of Birth',
  'Parent Phone' => 'Parent Phone',

  'We have e-mailed your password reset link!' => 'We have e-mailed your password reset link!',
  'Reset Password' => 'Reset Password',
  'Your password has been changed!' => 'Your password has been changed!',
  'If you did not request a password reset, no further action is required.' => 'If you did not request a password reset, no further action is required.',
  'You are receiving this email because we  received a password reset request for your account.' => 'You are receiving this email because we  received a password reset request for your account.',
  'You are only one step a way from your new password, recover your password now.' => 'You are only one step a way from your new password, recover your password now.',
  'Reset Password Request Is Expired!' => 'Reset Password Request Is Expired!',
  'I forgot my password' => 'I forgot my password',
  'Request new password' => 'Request new password',
  'You forgot your password? Here you can easily retrieve a new password.' => 'You forgot your password? Here you can easily retrieve a new password.',
  'Forget Password Request' => 'Forget Password Request',
  'Invalid Credentials' => 'Invalid Credentials',
  'Reservation not rejected so you can not edit reservation now' => 'Reservation not rejected so you can not edit reservation now',
  'Logs' => 'Reservations Logs',
  'Reservation Number' => 'Reservation Number',
  'User Name	' => 'User Name	',
  'User Type' => 'User Type',
  'Admin' => 'Admin',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  'app' =>[
    'Currency'=>'AED'
  ],
  'ar' => [
    'Title' => 'Title (ar)',
    'Address' => 'Address (ar)',
    'Description' => 'Description (ar)',
    'Title' => 'Title (ar)',
    'Short Description' => 'Short Description (ar)',
  ],
  'en' => [
    'Title' => 'Title (en)',
    'Address' => 'Address (en)',
    'Description' => 'Description (en)',
    'Title' => 'Title (en)',
    'Short Description' => 'Short Description (en)',
  ],

];
