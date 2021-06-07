
<template>
    <div class="main-panel">
        <div class="panel-header">
            <div class="header text-center">
            <h2 class="title">Maintenance</h2>
            <p class="p-blur text-center">This page will be handle all system primary data</p>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openSchoolYearModal" class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons loader_gear"></i></a>
                            <h4 class="card-title text-md">Default School Year & Semester</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-min" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">Name</th>
                                                <th class="text-sm">Default</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>School Year</td>
                                                <td v-for="data in get_school_years" :key="data.id" v-show="data.status == '1'">{{ data.school_year }}</td>
                                            </tr>
                                            <tr>
                                                <td>Semester</td>
                                                <td v-for="data in get_semesters" :key="data.id" v-show="data.status == '1'">{{ data.semester }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openRequirementModal" class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons ui-1_simple-add"></i></a>
                            <h4 class="card-title text-md">Requirements</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-min" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">Name</th>
                                                <th class="w-50 text-sm">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="!isLoading">
                                                <td colspan="5" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td>
                                            </tr>
                                            <tr v-for="data in requirements.data" :key="data.id">
                                                <td>{{ data.name }}</td>
                                                <td class="text-center"> 
                                                    <a class="pointer" @click="editRequirement(data)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer ">
                                    <pagination class="float-right" :data="requirements" @pagination-change-page="pageRequirement"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openCourseModal" class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons ui-1_simple-add"></i></a>
                            <h4 class="card-title text-md">Courses</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-min" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">Course</th>
                                                <th class="text-sm">Short Form</th>
                                                <th class="text-sm w-50">Year Levels</th>
                                                <th class="text-sm w-50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="!COisLoading">
                                                <td colspan="5" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td>
                                            </tr>
                                            <tr v-for="course in courses.data" :key="course.id">
                                                <td>{{course.name}}</td>
                                                <td>{{course.abbr}}</td>
                                                <td class="text-center">{{course.year_levels}}</td>
                                                <td class="text-center"> 
                                                    <a class="pointer" @click="editCourse(course)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer ">
                                    <pagination class="float-right" :data="courses" @pagination-change-page="pageCourse"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- MODALS -->

            <!-- #School Year Modal -->
            <div class="modal fade" id="modal-schoolyear" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-sm card-info">
                <div class="modal-content">
                        <form  @submit.prevent="updateDefault()">
                        <div class="modal-header">
                            <!-- <h4 class="modal-title" v-show="!editmode" >Add</h4>
                            <h4 class="modal-title" v-show="editmode">Update</h4> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>School Year</label>
                                    <select v-model="form.school_year" class="form-control"  name="" id="">
                                        <option label="Select School Year" disabled value="">Select School Year</option>
                                        <option v-for="data in get_school_years" :key="data.id" :value="data.id">{{ data.school_year }}</option> 
                                    </select>
                                <has-error :form="form" field="school_year"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <select v-model="form.semester" class="form-control"  name="" id="">
                                    <option label="Select Semester" disabled value="">Select Semester</option>
                                    <option v-for="data in get_semesters" :key="data.id" :label="data.semester" :value="data.id"></option> 
                                </select>
                                <has-error :form="form" field="semester"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Set</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="modal fade" id="modal-requirement" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-sm card-info">
                    <div class="modal-content">
                            <form  @submit.prevent="editmode ? updateRequirement() : createRequirement()">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Requirement</label>
                                    <input v-model="formRequirement.name" type="text" name="name"
                                        placeholder="Enter requirement..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-course" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-md card-info">
                <div class="modal-content">
                        <form  @submit.prevent="editmode ? updateCourse() : createCourse()">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label>Course</label>
                                <input v-model="courseForm.name" type="text" name="name"
                                    placeholder="Enter course..."
                                    class="form-control" :class="{ 'is-invalid': courseForm.errors.has('name') }">
                                <has-error :form="courseForm" field="name"></has-error>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                        <label>Short Form</label>
                                        <input v-model="courseForm.abbr" type="text" name="abbr"
                                            placeholder="Enter abbreviation..."
                                            class="form-control" :class="{ 'is-invalid': courseForm.errors.has('abbr') }">
                                        <has-error :form="courseForm" field="abbr"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Number of Year Levels</label>
                                        <input v-model="courseForm.year_levels" type="text" name="year_levels"
                                            placeholder="Enter number of year levels..."
                                            class="form-control" :class="{ 'is-invalid': courseForm.errors.has('year_levels') }">
                                        <has-error :form="courseForm" field="year_levels"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

   </div>
</template>

<script>
    export default {
        data () {
            return {
              editmode: false,
              isLoading: false,
              COisLoading: false,
              get_semesters:[],
              get_school_years: [],
              courses:{},
              requirements:{},
              form: new Form({
                school_year: '',
                semester: '',
              }),
              formRequirement: new Form({
                id:'',
                name: '',
              }),
              courseForm: new Form({
                id: '',
                name: '',
                abbr: '',
                year_levels: '',
              }),
            }
          },
          methods:{
              openSchoolYearModal(){
                this.editmode = false;
                this.form.reset();
                $('#modal-schoolyear').modal('show');
            },
            openRequirementModal(){
                 this.editmode = false;
                this.formRequirement.reset();
                $('#modal-requirement').modal('show');
            },
            updateDefault(){
                 this.$Progress.start();
                this.form.post('api/schoolyear/')
                .then(() => {
                    $('#modal-schoolyear').modal('hide');
                     Toast.fire({
                        icon: 'info',
                        title: 'Default Data Updated!'
                        })
                        this.$Progress.finish();
                         Fire.$emit('AfterUpdateSchoolYear');
                         this.form.reset();
                         this.editmode = false;
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },

            createRequirement(){
                this.$Progress.start();
                this.formRequirement.post('api/requirement')
                .then(()=>{
                    Fire.$emit('AfterCreateRequirement');
                    $('#modal-requirement').modal('hide')
                    this.courseForm.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Requirement Added'
                        })
                    this.$Progress.finish();
                })
                .catch((error)=>{
                   this.$Progress.fail();
                   Toast.fire({
                        icon: 'warning',
                        title: 'Ops! Something went wrong.'
                        })
                })
            },
            editRequirement(data){
                this.editmode = true;
                this.formRequirement.reset();
                $('#modal-requirement').modal('show');
                this.formRequirement.fill(data);
            },

            updateRequirement(){
            this.$Progress.start();
            this.formRequirement.put('api/requirement/'+this.formRequirement.id)
            .then(() => {
                    $('#modal-requirement').modal('hide');
                        Toast.fire({
                        icon: 'success',
                        title: 'Requirement Updated!'
                        })
                        this.$Progress.finish();
                            Fire.$emit('AfterCreateRequirement');
                            this.formRequirement.reset();
                            this.editmode = false;
                })
            .catch(() => {
                    this.$Progress.fail();
                });
            },  
             pageRequirement(){
                  axios.get('api/requirement?page=' + page)
                        .then(response => {
                            this.requirements = response.data.data;
                        });
            },
          
          // COURSE METHODS
            openCourseModal(){
                    this.editmode = false;
                    this.courseForm.reset();
                    $('#modal-course').modal('show');
                },
            createCourse(){
                    this.$Progress.start();
                    this.courseForm.post('api/course')
                    .then(()=>{
                        Fire.$emit('AfterCreateCourse');
                        $('#modal-course').modal('hide')
                        this.courseForm.reset();
                        Toast.fire({
                            icon: 'success',
                            title: 'Course Added'
                            })
                        this.$Progress.finish();
                    })
                    .catch((error)=>{
                    this.$Progress.fail();
                    Toast.fire({
                            icon: 'warning',
                            title: 'Ops! Something went wrong.'
                            })
                    })
                },
            editCourse(course){
                    this.editmode = true;
                    this.courseForm.reset();
                    $('#modal-course').modal('show');
                    this.courseForm.fill(course);
                },
            updateCourse(){
                this.$Progress.start();
                this.courseForm.put('api/course/'+this.courseForm.id)
                .then(() => {
                    $('#modal-course').modal('hide');
                        Toast.fire({
                        icon: 'success',
                        title: 'Course Updated!'
                        })
                        this.$Progress.finish();
                            Fire.$emit('AfterCreateCourse');
                            this.courseForm.reset();
                            this.editmode = false;
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },        

            pageCourse(){
                axios.get('api/course?page=' + page)
                        .then(response => {
                            this.courses = response.data.data;
                        });
            },
           

         


            loadSettings(){
                axios.get('api/requirement')
                .then((data) => {
                    this.isLoading = false
                    this.requirements = data.data.data
                    
                })
                .finally(() => {
                    this.isLoading = true
                }); 
                
                axios.get('api/course')
                .then((data) => {
                    this.COisLoading = false
                    this.courses = data.data.data
                
                })
                .finally(() => {
                    this.COisLoading = true
                });

            },
          },
        async created(){
             axios.get("api/getschoolyear").then(({ data }) => (this.get_school_years = data));
             axios.get("api/getsemester").then(({ data }) => (this.get_semesters = data));
            //  axios.get("api/get-default").then(({ data }) => (this.get_school_years = data));
            

            this.loadSettings();

             Fire.$on('AfterCreateRequirement',() => {
              axios.get('api/requirement')
                    .then((data) => {
                        this.isLoading = false
                        this.requirements = data.data.data
                        
                    })
                    .finally(() => {
                        this.isLoading = true
                    }); 
            });
            Fire.$on('AfterCreateCourse',() => {
              axios.get('api/course')
                .then((data) => {
                    this.COisLoading = false
                    this.courses = data.data.data
                
                })
                .finally(() => {
                    this.COisLoading = true
                }); 
            });
            // Fire.$on('AfterUpdateSchoolYear',() => {
            //    axios.get("api/schoolyear").then(({ data }) => (this.school_years = data.data));
            // });

        }
    }
</script>
