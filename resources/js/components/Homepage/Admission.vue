<template>
    <div >
        <section id="hero" class="d-flex align-items-center page">
            <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Welcome to <span>ASCoB Admission</span></h1>
                        <h2>Start where you are. Use what you have. Do what you can.</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                <h2>ASCoB Admission</h2>
                <ol>
                    <li><router-link to="/">Home</router-link></li>
                    <li>Admission</li>
                </ol>
                </div>
            </div>
        </section>
        <section class="inner-page" data-aos="slide-up" data-aos-delay="500">
            <div class="container">
                <div class="section-title">
                <h2>Admission Form</h2>
                <p>Enter student's admission information below</p>
                </div>
              <form-wizard @on-complete="onComplete" :color="'#0837c4'" :finishButtonText="editmode == true ? 'Update' : 'Save'">
                    <tab-content title="Personal Details" icon="fa fa-user">
                        <div class="row">
                            <div class="col-md-3 profile-holder">
                                <div id="preview">
                                    <img v-if="url" :src="url" />
                                </div>
                                <input id="student-profile" type="file" @change="onFileChange" />
                                <label for="student-profile" class="custom-file-upload">
                                    <i class="now-ui-icons arrows-1_cloud-upload-94"></i> Upload Student Profile Image
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Current School Year</label>
                                            <input v-model="form.school_year_id" type="text" name="school_year_id" class="form-control"  disabled :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                            <has-error :form="form" field="school_year_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Current Semester</label>
                                            <input v-model="form.semester_id" type="text" name="semester_id" class="form-control" disabled :class="{ 'is-invalid': form.errors.has('semester_id') }">
                                            <has-error :form="form" field="semester_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Status</label>
                                            <select v-model="form.status" name="" id="" class="form-control">
                                                <option value="" selected disabled>Select Marital Status</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                            </select>
                                            <has-error :form="form" field="status"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>First Name</label>
                                            <input v-model="form.first_name" type="text" name="first_name" placeholder="Enter first name" class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                            <has-error :form="form" field="first_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Middle Name</label>
                                            <input v-model="form.middle_name" type="text" name="middle_name" placeholder="Enter middle name" class="form-control" :class="{ 'is-invalid': form.errors.has('middle_name') }">
                                            <has-error :form="form" field="middle_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Last Name</label>
                                            <input v-model="form.last_name" type="text" name="last_name" placeholder="Enter last name" class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                            <has-error :form="form" field="last_name"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Course</label>
                                            <select v-model="form.course_id" class="form-control"  name="course_id" id="" :class="{ 'is-invalid': form.errors.has('course_id') }">
                                                <option label="Select Course" disabled value="" >Select Course</option>
                                                <option v-for="data in get_courses" :key="data.id" :label="data.abbr" @click.prevent="getYearLevels(data)" :value="data.id"></option> 
                                            </select>
                                            <has-error :form="form" field="course_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Year Level</label>
                                            <select v-model="form.year_level" class="form-control"  name="year_level" id="" :class="{ 'is-invalid': form.errors.has('year_level') }">
                                                <option label="Select Year Level" disabled value="">Select Year Level</option>
                                                <option v-for="data in get_yearlevels" :key="data" :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
                                            </select>
                                            <has-error :form="form" field="year_level"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Gender</label>
                                            <select v-model="form.gender" name="gender" id="" class="form-control">
                                                <option value="" selected disabled>Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <has-error :form="form" field="gender"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Contact Number</label>
                                            <input v-model="form.contact" type="text" name="contact" class="form-control" :class="{ 'is-invalid': form.errors.has('contact') }">
                                            <has-error :form="form" field="contact"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Email Address</label>
                                            <input v-model="form.email" type="text" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Citizenship</label>
                                            <input v-model="form.citizenship" type="text" name="citizenship" class="form-control" :class="{ 'is-invalid': form.errors.has('citizenship') }">
                                            <has-error :form="form" field="citizenship"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Religion</label>
                                            <input v-model="form.religion" type="text" name="religion" class="form-control" :class="{ 'is-invalid': form.errors.has('religion') }">
                                            <has-error :form="form" field="religion"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Date of Birth</label>
                                            <input v-model="form.birthday" type="text" name="birthday" class="form-control" :class="{ 'is-invalid': form.errors.has('birthday') }">
                                            <has-error :form="form" field="birthday"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Type of Student</label>
                                            <select v-model="form.type_student" name="" id="" class="form-control">
                                                <option value="" selected disabled>Select Option</option>
                                                <option value="new">New Student</option>
                                                <option value="old">Old Student</option>
                                                <option value="transferee">Transferee Student</option>
                                            </select>
                                            <has-error :form="form" field="type_student"></has-error>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row mt-4">
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea v-model="form.address" rows="4" cols="80" class="form-control" placeholder="House #, Street, Barangay, Munipality, Region " value="Mike" spellcheck="false">
                                        
                                    </textarea>
                                </div>
                            </div>
                        </div>   
                    </tab-content>
                    <tab-content title="Parent/Guardian Info" icon="fa fa-user-circle">
                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="wizard-form-title">Father's Information</h2>
                                <input v-model="form.father_type" type="hidden" name="type" class="form-control">
                                <div class="form-group"> 
                                    <label>Name</label>
                                    <input v-model="form.father_name" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                    <has-error :form="form" field="school_year_id"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Status</label>
                                    <select v-model="form.father_status" name="" id="" class="form-control">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="living">Living</option>
                                        <option value="deceased">Deceased</option>
                                    </select>
                                    <has-error :form="form" field="father_status"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Mobile #</label>
                                    <input v-model="form.father_contact" type="text" name="father_contact" class="form-control" :class="{ 'is-invalid': form.errors.has('father_contact') }">
                                    <has-error :form="form" field="father_contact"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Occupation</label>
                                    <input v-model="form.father_occupation" type="text" name="father_occupation" class="form-control" :class="{ 'is-invalid': form.errors.has('father_occupation') }">
                                    <has-error :form="form" field="father_occupation"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Name</label>
                                    <input v-model="form.father_company" type="text" name="father_company" class="form-control" :class="{ 'is-invalid': form.errors.has('father_company') }">
                                    <has-error :form="form" field="father_company"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Address</label>
                                    <input v-model="form.father_company_address" type="text" name="father_company_address" class="form-control" :class="{ 'is-invalid': form.errors.has('father_company_address') }">
                                    <has-error :form="form" field="father_company_address"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Office Tel. No.</label>
                                    <input v-model="form.father_tel" type="text" name="father_tel" class="form-control" :class="{ 'is-invalid': form.errors.has('father_tel') }">
                                    <has-error :form="form" field="father_tel"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Email Address</label>
                                    <input v-model="form.father_email" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('father_email') }">
                                    <has-error :form="form" field="father_email"></has-error>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h2 class="wizard-form-title">Mother's Information</h2>
                                <input v-model="form.mother_type" type="hidden" name="type" class="form-control">
                                <div class="form-group"> 
                                    <label>Name</label>
                                    <input v-model="form.mother_name" type="text" name="mother_name" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_name') }">
                                    <has-error :form="form" field="mother_name"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Status</label>
                                    <select v-model="form.mother_status" name="" id="" class="form-control">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="living">Living</option>
                                        <option value="deceased">Deceased</option>
                                    </select>
                                    <has-error :form="form" field="mother_status"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Mobile #</label>
                                    <input v-model="form.mother_contact" type="text" name="mother_contact" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_contact') }">
                                    <has-error :form="form" field="mother_contact"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Occupation</label>
                                    <input v-model="form.mother_occupation" type="text" name="mother_occupation" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_occupation') }">
                                    <has-error :form="form" field="mother_occupation"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Name</label>
                                    <input v-model="form.mother_company" type="text" name="mother_company" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_company') }">
                                    <has-error :form="form" field="mother_company"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Address</label>
                                    <input v-model="form.mother_company_address" type="text" name="mother_company_address" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_company_address') }">
                                    <has-error :form="form" field="mother_company_address"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Office Tel. No.</label>
                                    <input v-model="form.mother_tel" type="text" name="mother_tel" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_tel') }">
                                    <has-error :form="form" field="mother_tel"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Email Address</label>
                                    <input v-model="form.mother_email" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('mother_email') }">
                                    <has-error :form="form" field="mother_email"></has-error>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h2 class="wizard-form-title">Guardian's Information</h2>
                                 <input v-model="form.guardian_type" type="hidden" name="type" class="form-control">
                                <div class="form-group"> 
                                    <label>Name</label>
                                    <input v-model="form.guardian_name" type="text" name="guardian_name" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_name') }">
                                    <has-error :form="form" field="guardian_name"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Relationship</label>
                                    <input v-model="form.guardian_relationship" type="text" name="guardian_relationship" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_relationship') }">
                                    <has-error :form="form" field="guardian_relationship"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Mobile #</label>
                                    <input v-model="form.guardian_contact" type="text" name="guardian_contact" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_contact') }">
                                    <has-error :form="form" field="guardian_contact"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Occupation</label>
                                    <input v-model="form.guardian_occupation" type="text" name="guardian_occupation" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_occupation') }">
                                    <has-error :form="form" field="guardian_occupation"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Name</label>
                                    <input v-model="form.guardian_company" type="text" name="guardian_company" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_company') }">
                                    <has-error :form="form" field="guardian_company"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Company Address</label>
                                    <input v-model="form.guardian_company_address" type="text" name="guardian_company_address" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_company_address') }">
                                    <has-error :form="form" field="guardian_company_address"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Office Tel. No.</label>
                                    <input v-model="form.guardian_tel" type="text" name="guardian_tel" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_tel') }">
                                    <has-error :form="form" field="guardian_tel"></has-error>
                                </div>
                                <div class="form-group"> 
                                    <label>Email Address</label>
                                    <input v-model="form.guardian_email" type="text" name="guardian_email" class="form-control" :class="{ 'is-invalid': form.errors.has('guardian_email') }">
                                    <has-error :form="form" field="guardian_email"></has-error>
                                </div>
                            </div>
                        </div>
                    </tab-content>
                    <tab-content title="Educational Background Info" icon="fa fa-university">
                        <h3>Schools Attended</h3>
                        <p>Please start with the most recent. Please indicate levels, i.e. Kinder 1, Prep, etc. <span class="text-muted">Please click plus button to add row and minus button to remove row.</span></p>
                         <table class="table table-stripped table-bordered populate">
                            <thead>
                                <tr>
                                    <th class="text-sm w-30p">Name of School</th>
                                    <th class="text-sm w-40p">School Address</th>
                                    <th class="text-sm w-15p">School Year</th>
                                    <th class="text-sm w-10p">Level</th>
                                    <th class="plus-action text-center w-50 p-0"><button @click="addRow($event),counter += 1" class="btn btn-sm bg-blue btn-plus"><i class=" fa fa-plus-circle"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="(itemData,index) in form.schoolsAttended" :key="index">
                                    <td>
                                        <input v-model="itemData.school_name" type="text" name="school_name" placeholder="Enter school name" class="form-control" :class="{ 'is-invalid': form.errors.has('schoolsAttended.school_name') }">
                                    </td>
                                    <td>
                                        <input v-model="itemData.school_address" type="text" name="school_address" placeholder="Enter school address" class="form-control" :class="{ 'is-invalid': form.errors.has('schoolsAttended.school_address') }">
                                    </td>
                                    <td>
                                        <input v-model="itemData.school_year" type="text" name="school_year" placeholder="Enter school year" class="form-control" :class="{ 'is-invalid': form.errors.has('schoolsAttended.school_year') }">
                                    </td>
                                    <td>
                                        <input v-model="itemData.level" type="text" name="level" placeholder="Enter school name" class="form-control" :class="{ 'is-invalid': form.errors.has('schoolsAttended.level') }">
                                    </td>
                                    <td class="text-center">
                                        <button  @click="removeRow(itemData,$event)" class="btn btn-sm btn-minus"><i class="fa fa-minus-circle"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </tab-content>
                    <tab-content title="Subjects Loading" icon="fa fa-graduation-cap ">
                        Subjects
                    </tab-content>
                    <tab-content title="Requirements" icon="fa fa-file ">
                        Requirements
                    </tab-content>
                </form-wizard>
            </div>
        </section>



    </div>
</template>

<script>

    export default {
       
       props: {
                title: {
                    type: String,
                    default: 'Student Details Form'
                },
                subtitle: {
                    type: String,
                    default: 'test'
                },
                nextButtonText: {
                    type: String,
                    default: 'Nexts'
                },
                backButtonText: {
                    type: String,
                    default: 'Back'
                },
                finishButtonText: {
                    type: String,
                    default: 'Submit'
                },
                stepSize: {
                    type: String,
                    default: 'md',
                    validator: (value) => {
                    let acceptedValues = ['xs', 'sm', 'md', 'lg']
                    return acceptedValues.indexOf(value) !== -1
                    }
                },
                validateOnBack: Boolean,
                color: {
                    type: String,
                    default: '#444'
                },
                errorColor: {
                    type: String,
                    default: '#8b0000'
                },
                shape: {
                    type: String,
                    default: 'circle'
                },
                transition: {
                    type: String,
                    default: '' //name of the transition when transition between steps
                },

        },
        data () {
            return {
              editmode: false,
              isLoading: false,
              url: '/images/profile.png',
              get_school_years:[],
              get_current_school_year:[],
              get_semesters:[],
              get_courses:[],
              get_yearlevels:0,
              subjects:{},
              courses:{},
              counter:1,
              form: new Form({
                id: '',
                school_year_id: '',
                semester_id:'',
                status:'',
                first_name:'',
                last_name:'',
                middle_name:'',
                course_id:'',
                year_level: '',
                gender:'',
                contact:'',
                email:'',
                citizenship:'',
                religion:'',
                birthday:'',
                type_student:'',
                address:'',

                father_type:'father',
                father_name:'',
                father_status:'',
                father_contact:'',
                father_occupation:'',
                father_company:'',
                father_company_address:'',
                father_tel:'',
                father_email:'',

                mother_type:'mother',
                mother_name:'',
                mother_status:'',
                mother_contact:'',
                mother_occupation:'',
                mother_company:'',
                mother_company_address:'',
                mother_tel:'',
                mother_email:'',

                guardian_type:'guardian',
                guardian_name:'',
                guardian_relationship:'',
                guardian_contact:'',
                guardian_occupation:'',
                guardian_company:'',
                guardian_company_address:'',
                guardian_tel:'',
                guardian_email:'',


                schoolsAttended:[
                    {
                    id:'',
                    school_name:'',
                    school_address:'',
                    school_year:'',
                    level:'',
                    }
                ],
              }),
            }
          },
          methods:{
            openModal(){
                this.editmode = false;
                this.form.reset();
                $('#modal').modal('show');
            },
            addRow(event){
                 event.preventDefault()
                    this.form.schoolsAttended.push({
                        index:0,
                        school_name:'',
                        school_address:'',
                        school_year:'',
                        level:'',
                  });
                    
            },
            removeRow(itemData,event){
                this.counter--
                event.preventDefault()
                this.form.schoolsAttended.splice(this.form.schoolsAttended.indexOf(itemData),1);
            },
            isNumber: function(evt) {
              evt = (evt) ? evt : window.event;
              var charCode = (evt.which) ? evt.which : evt.keyCode;
              if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
                 Toast.fire({
                        icon:'warning',
                        type: 'warning',
                        title: 'Number Only.'
                        })
               
              } else {
                return true;
              }
            },
            onComplete(){
                this.$Progress.start();
                this.form.post('api/enrollment')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#modal').modal('hide')
                    this.form.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Success! Please wait for your confirmation.'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Opp! Something went wrong'
                    })
                })
            },
            onFileChange(e) {
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },

            createStudent(){
                this.$Progress.start();
                this.form.post('api/enrollment')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#modal').modal('hide')
                    this.form.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Student Added'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Opp! Something went wrong'
                    })
                })
            },
           updateStudent(){
                this.$Progress.start();
                this.form.put('api/subject/'+this.form.id)
                .then((response) => {
                   $('#updateModal').modal('hide');
                     Toast.fire({
                        icon: 'success',
                        title: 'Subject Updated!'
                        })
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                         this.form.reset();
                         this.editmode = false;
                })
                .catch((response) => {
                     this.$Progress.fail();
                });
            },
            pageSubject(){
                axios.get('api/subject?page=' + page)
                    .then(response => {
                        this.subjects = response.data.data;
                    });
            },
        
        //     loadSettings(){
        //         axios.get('api/subject')
        //             .then((data) => {
        //             this.isLoading = false
        //             this.subjects = data.data.data
                    
        //             })
        //             .finally(() => {
        //                 this.isLoading = true
        //             });
        //     },
        },
        async created(){
             axios.get("api/getschoolyear").then(({ data }) => (this.get_school_years = data));
             axios.get('api/getcurrentschoolyear')
                    .then((data) => {
                    this.form.school_year_id = data.data[0].school_year
                    })
                    .finally(() => {
                        this.isLoading = true
                    });
            axios.get('api/getcurrentsemester')
                    .then((data) => {
                    this.form.semester_id = data.data[0].semester
                    })
                    .finally(() => {
                        this.isLoading = true
                    });

             axios.get("api/getsemester").then(({ data }) => (this.get_semesters = data));
             axios.get("api/getcourse").then(({ data }) => (this.get_courses = data));
            

            // this.loadSettings();
            // Fire.$on('AfterCreate',() => {
            //    axios.get('api/subject')
            //         .then((data) => {
            //         this.isLoading = false
            //         this.subjects = data.data.data
                    
            //         })
            //         .finally(() => {
            //             this.isLoading = true
            //         });
            // });

        }
    }
</script>
