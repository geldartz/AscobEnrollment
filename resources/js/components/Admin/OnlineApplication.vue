
<template>
    <div class="main-panel">
        <div class="panel-header">
            <div class="header text-center">
            <h2 class="title">Online Applicants</h2>
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
                                           <tr v-for="data in enrollies.data" :key="data.id">
                                               <td>{{ data.student_id }}</td>
                                               <td>{{ data.first_name }} {{ data.last_name }}</td>
                                               <td>{{ data.units }}</td>
                                               <td>{{ data.class }}</td>
                                               <td>{{ data.course.abbr }} - {{ (data.year_level == 1 ? 'I' : data.year_level == 2 ? 'II' :  data.year_level == 3 ? 'III' : data.year_level == 4 ? 'IV' : 'V' ) }}</td>
                                               <td class="text-center"> 
                                                    <a class="pointer" @click="editSubject(data)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                               
                                           </tr>
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
              enrollies:{},
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
        
            loadData(){
                axios.get('api/enrollment')
                    .then((data) => {
                    this.isLoading = false
                    this.enrollies = data.data.data
                    
                    })
                    .finally(() => {
                        this.isLoading = true
                    });
            },
        },
        async created(){
             axios.get("api/getschoolyear").then(({ data }) => (this.get_school_years = data));
             axios.get("api/getsemester").then(({ data }) => (this.get_semesters = data));
             axios.get("api/getcourse").then(({ data }) => (this.get_courses = data));
            

             this.loadData();
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
