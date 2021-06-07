
<template>
    <div class="main-panel">
        <div class="panel-header">
            <div class="header text-center">
            <h2 class="title">Student Management</h2>
            <p class="p-blur text-center">This page will handle all student's data</p>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openModal"  class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons ui-1_simple-add"></i></a>
                            <h4 class="card-title text-md">Students</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <form action="" class="pull-left py-2 filter-form">
                                            <select class="form-control" name="" id="">
                                                <option value="" disabled selected>Select School Year</option>
                                                <option v-for="data in get_school_years" :key="data.id" :value="data.id">{{ data.school_year }}</option> 
                                            </select>
                                            <select class="form-control" name="" id="">
                                                <option value="" disabled selected>Select Semester</option>
                                                <option v-for="data in get_semesters" :key="data.id" :label="data.semester" :value="data.id"></option> 
                                            </select>
                                            <select v-model="form.course_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('course_id') }">
                                                <option label="Select Course" disabled value="" >Select Course</option>
                                                <option v-for="data in get_courses" :key="data.id" :label="data.abbr" @click.prevent="getYearLevels(data)" :value="data.id"></option> 
                                            </select>
                                            <select v-model="form.year_level" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('year_level') }">
                                                <option label="Select Year Level" disabled value="">Select Year Level</option>
                                                <option v-for="data in get_yearlevels" :key="data" :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
                                            </select>
                                            <button type="button" class="btn btn-tool btn-min">
                                                Filter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">UID</th>
                                                <th class="text-sm">Student Name</th>
                                                <th class="text-sm">Course & Year</th>
                                                <th class="text-sm">Contact</th>
                                                <th class="text-sm">Email</th>
                                                <th class="text-sm w-50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="!isLoading">
                                                <td colspan="6" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td>
                                            </tr>
                                           <!-- <tr v-for="data in subjects.data" :key="data.id">
                                               <td>{{ data.short_name }}</td>
                                               <td>{{ data.name }}</td>
                                               <td>{{ data.units }}</td>
                                               <td>{{ data.class }}</td>
                                               <td>{{ data.course.abbr }} - {{ (data.year_level == 1 ? 'I' : data.year_level == 2 ? 'II' :  data.year_level == 3 ? 'III' : data.year_level == 4 ? 'IV' : 'V' ) }}</td>
                                               <td class="text-center"> 
                                                    <a class="pointer" @click="editSubject(data)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                               
                                           </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <!-- <pagination class="float-right" :data="subjects" @pagination-change-page="pageSubject"></pagination> -->
                        </div>
                    </div>
                </div>




            </div>
        </div>
        <!-- MODALS -->

            <!-- #School Year Modal -->
            <div class="modal fade" id="modal" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl card-info">
                <div class="modal-content">
                        <form  @submit.prevent="editmode ? updateStudent() : createStudent()">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form-wizard @on-complete="onComplete" :title="'Addmission Form'" :subtitle="'Enter student\'s admission information below'" :color="'#204065'" :finishButtonText="editmode == true ? 'Update' : 'Save'">
                                <tab-content title="Personal Details" icon="now-ui-icons users_single-02">
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
                                                        <label>Student ID</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" disabled :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Current School Year</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" disabled :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Current Semester</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" disabled :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>First Name</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" placeholder="Enter first name" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Middle Name</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" placeholder="Enter middle name" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Last Name</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" placeholder="Enter last name" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Course</label>
                                                        <select v-model="form.course_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('course_id') }">
                                                            <option label="Select Course" disabled value="" >Select Course</option>
                                                            <option v-for="data in get_courses" :key="data.id" :label="data.abbr" @click.prevent="getYearLevels(data)" :value="data.id"></option> 
                                                        </select>
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Year Level</label>
                                                        <select v-model="form.year_level" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('year_level') }">
                                                            <option label="Select Year Level" disabled value="">Select Year Level</option>
                                                            <option v-for="data in get_yearlevels" :key="data" :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
                                                        </select>
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Gender</label>
                                                        <select name="" id="" class="form-control">
                                                            <option value="" selected disabled>Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Contact Number</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Email Address</label>
                                                        <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group"> 
                                                        <label>Status</label>
                                                        <select name="" id="" class="form-control">
                                                            <option value="" selected disabled>Select Marital Status</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                        <has-error :form="form" field="school_year_id"></has-error>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                                <label>Citizenship</label>
                                                <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                <has-error :form="form" field="school_year_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                                <label>Religion</label>
                                                <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                <has-error :form="form" field="school_year_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                                <label>Date of Birth</label>
                                                <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                <has-error :form="form" field="school_year_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                                <label>Place of Birth</label>
                                                <input v-model="form.school_year_id" type="text" name="abbr" class="form-control" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                <has-error :form="form" field="school_year_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>Address</label>
                                            <textarea rows="4" cols="80" class="form-control" placeholder="House #, Street, Barangay, Munipality, Region " value="Mike" spellcheck="false">
                                                
                                            </textarea>
                                        </div>
                                        </div>
                                    </div>   
                                </tab-content>
                                <tab-content title="Parent/Guardian Info" icon="now-ui-icons users_circle-08">
                                    Parent/Guardian Info
                                </tab-content>
                                <tab-content title="Educational Background Info" icon="now-ui-icons business_badge">
                                    Educational
                                </tab-content>
                                <tab-content title="Health/Psysiological/Bahavioral Concerns" icon="now-ui-icons ui-2_favourite-28">
                                   Health/Psysiological/Bahavioral Concerns
                                </tab-content>
                                <tab-content title="Subjects Loading" icon="now-ui-icons files_paper">
                                    Subjects
                                </tab-content>
                                <tab-content title="Requirements" icon="now-ui-icons education_paper">
                                    Requirements
                                </tab-content>
                            </form-wizard>
                        </div>
                    </form>
                </div>
                </div>
            </div>




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
                course_id:'',
                year_level:'',
                subject:[
                    {
                    id:'',
                    short_name:'',
                    name:'',
                    units:'',
                    class:'',
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
                alert('GG')
            },
            onFileChange(e) {
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },
        //     editSubject(data){
        //         this.editmode = true;
        //         this.form.reset();
        //         this.form.subject[0].id = data.id
        //         this.form.id = data.id
        //         this.form.subject[0].short_name = data.short_name
        //         this.form.subject[0].name = data.name
        //         this.form.subject[0].units = data.units
        //         this.form.subject[0].class = data.class

        //         this.form.school_year_id = data.school_year_id
        //         this.form.semester_id = data.semester_id
        //         this.form.course_id = data.course_id
        //         this.form.year_level = data.year_level
                
        //         $('#updateModal').modal('show');
        //     },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },

            createStudent(){
                this.$Progress.start();
                this.form.post('api/subject')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#modal').modal('hide')
                    this.form.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'All Data Added'
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
