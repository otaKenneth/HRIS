<template>
    <div class="">
        <table class="table table-striped table-bordered">
            <thead class="thead thead-dark">
                <tr>
                    <th>#</th>
                    <th>Basic Info</th>
                    <th>Job Info</th>
                    <th>Salary</th>
                    <th>Allowance</th>
                    <th>Others</th>
                    <th class="text-center"> <i class="fa fa-cog"></i> </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, key) in users" :key="key">
                    <td> {{key+1}} </td>
                    <td>
                        <div> {{user['firstname']}} {{user['middlename']}} {{user['lastname']}} </div>
                        <div class="text-sm"> {{user['username']}} - {{['Administrator','User'][user['userlvl']]}} </div>
                    </td>
                    <td>
                        <div class="text-sm"> {{user['job_status']}} - {{user['job_position']}} </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="actions d-flex justify-content-around">
                            <a :href="`/Employee/${user.id}/Edit#${sharp}`" class="btn btn-warning text-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-primary text-sm" data-toggle="tooltip" data-placement="bottom" title="View"><i class="fa fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['items','sharp'],
    data () {
        return {
            users: this.items,
        }
    }
}
</script>