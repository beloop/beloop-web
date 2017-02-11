<template scope="props">
<div class="page-head">
  <!-- <h2>{{ props.pageName | trans }} <a href="#" class="btn btn-space btn-primary btn-md pull-right"><i class="icon icon-left s7-plus"></i> Action name</a></h2> -->
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
</template>

<script>
  export default {
    name: 'page-wrapper',
    data () {
      return {}
    }
  }
</script>
