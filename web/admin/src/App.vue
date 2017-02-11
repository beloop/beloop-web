<template>
  <div id="beloop-admin">
    <div class="page-head">
      <h2>{{ 'admin.page.course.title' | trans }} <a href="https://learn.deliciousyetbeautiful.com/admin/course/new" class="btn btn-space btn-primary btn-md pull-right"><i class="icon icon-left s7-plus"></i> New</a></h2>
    </div>
    <div class="main-content">
      <div class="row">
        <div class="col-sm-12">
          <div class="widget widget-fullwidth widget-small">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'beloop-admin',
  data () {
    return {
      pageName: this.$route.name
    }
  }
}
</script>

<style>
</style>
