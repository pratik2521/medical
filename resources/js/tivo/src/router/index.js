import { createRouter, createWebHistory } from 'vue-router'
import BodyView from "../layout/BodyView.vue"

import LoginView from "../pages/Auth/LoginView.vue"
import RegitserView from "../pages/Auth/RegitserView.vue"
import ForgotPasswordView from "../pages/Auth/ForgotPasswordView.vue"
import ResetPasswordView from "../pages/Auth/ResetPasswordView.vue"

import CreateProperty from "../pages/Dashboard/CreateProperty.vue"

import LeadForm from "../pages/Lead/LeadForm.vue"
import LeadTableView from '../pages/Lead/LeadTableView.vue'
import ViewLeadForm from '../pages/Lead/ViewLeadForm.vue'


import EmployeeForm from "../pages/Employee/EmployeeForm.vue"
import EmployeeTableView from '../pages/Employee/EmployeeTableView.vue'
import ViewEmployeeForm from '../pages/Employee/ViewEmployeeForm.vue'

import QoutFormView from "../pages/Quote/QoutFormView.vue"
import QuoteTableView from "../pages/Quote/QuoteTableView.vue"
import ViewQoutFormView from "../pages/Quote/ViewQoutFormView.vue"
import addGroup from "../pages/Addgroup/addGroup.vue"
import AddLead from "../pages/AddLead/CreateLead.vue"
import Dashboard from "../pages/Dashboard/Dashboard"
import CategoryTableView from '../pages/Category/CategoryTableView.vue'
import CategoryFrom from '../pages/Category/CategoryFrom.vue'
import ProductTableView from '../pages/Product/ProductTableView.vue'
import ProductFrom from '../pages/Product/ProductFrom.vue'
import ProductTab from '../pages/Product/ProductTab.vue'
import AdministrationForm from '../pages/Administration/AdministrationForm.vue'
import AdministrationTable from '../pages/Administration/AdministrationTable.vue'
import Admin from '../pages/Admin/Admin.vue'
import AddProductFrom from '../pages/Admin/AddProductFrom.vue'
import AddImage from '../pages/Admin/AddImage.vue'
import Layout from '../pages/Admin/Layout.vue'
import Preview from '../pages/Admin/Preview.vue'


const routes = [
 {
   path:"/",
   component:BodyView,
   children:[
     {
       path:"/",
       name:"Create",
       component:CreateProperty,
       props: true,
     },
     {
      path:"/dashboard",
      name:"dashbord",
      component:Dashboard,
      props: true,
    },
     {
      path:"/admin",
      name:"Admin",
      component:Admin,
      props: true,
    },
     {
      path:"/create-lead-form/:id?",
      name:"lead",
      component:LeadForm,
      props: true,
    },
    {
      path:"/update-addproduct-form/:id?",
      name:"AddProductFrom",
      component:AddProductFrom,
      props: true,
    },
    {
      path:"/layout-form",
      name:"Layout",
      component:Layout,
      props: true,
    },
    {
      path:"/preview-form/:id?",
      name:"Preview",
      component:Preview,
      props: true,
    },
    {
      path:"/create-addproduct-form/",
      name:"AddImage",
      component:AddImage,
      props: true,
    },
    {
      path:"/lead-data",
      name:"LeadTable",
      component:LeadTableView,
      props: true,
    },
    {
      path:"/lead-view-form/:id?",
      name:"ViewPage",
      component:ViewLeadForm,
      props:true
    },
     {
      path:"/create-employee-form/:id?",
      name:"EmployeeForm",
      component:EmployeeForm,
      props: true,
    },
    {
      path:"/employee-data",
      name:"EmployeeTableView",
      component:EmployeeTableView,
      props: true,
    },
    {
      path:"/employee-view-form/:id?",
      name:"ViewEmployeePage",
      component:ViewEmployeeForm,
      props:true
    },
    {
      path:"/create-quote-form/:id?",
      name:"QoutFormView",
      component:QoutFormView,
      props: true,
    },
    {
      path:"/quote-data",
      name:"QuoteTableView",
      component:QuoteTableView,
      props: true,
    },
    {
      path:"/quote-view-form/:id?",
      name:"ViewQoutFormView",
      component:ViewQoutFormView,
      props:true
    },
    {
      path:"/add-group",
      name:"addGroup",
      component:addGroup,
      props: true,
    },
    {
      path:"/add-lead",
      name:"AddLead",
      component:AddLead,
      props:true
    },
   
    {
      path:"/category-data",
      name:"CategoryTableView",
      component:CategoryTableView,
      props: true,
    },
    
    {
      path:"/create-category-form/:id?",
      name:"CategoryFrom",
      component:CategoryFrom,
      props: true,
    },
    {
      path:"/product-data",
      name:"ProductTableView",
      component:ProductTableView,
      props: true,
    },
    
    {
      path:"/create-product-form/:id?",
      name:"ProductFrom",
      component:ProductFrom,
      props: true,
    },
    {
      path:"/update-productTable-form/:id?",
      name:"ProductTab",
      component:ProductTab,
      props: true,
    },
    {
      path:"/create-Administration-form/:id?",
      name:"AdministrationForm",
      component:AdministrationForm,
      props: true,
      
    },
    {
      path:"/administration-data",
      name:"AdministrationTable",
      component:AdministrationTable,
      props: true,
    },
    // {
    //   path:"/product-price-form/:id?",
    //   name:"ProductPriceForm",
    //   component:ProductPriceForm,
    //   props: true,
    // },
    // {
    //   path:"/product-updateship-form/:id?",
    //   name:"UpdateShipPrice",
    //   component:UpdateShipPrice,
    //   props: true,
    // },
    
   ]
 },
 {
  path:"/auth/login",
  component:LoginView
 },
 {
  path:"/auth/register",
  component:RegitserView
 },
 {
  path:"/auth/forgot",
  component:ForgotPasswordView
 },
 {
  path:"/auth/reset-password",
  component:ResetPasswordView
 }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkExactActiveClass: 'active',
})

router.beforeEach((to, from, next) => {

  const  path = ['/auth/login','/auth/register','/auth/forgot'];
  if (path.includes(to.path) || localStorage.getItem('isAuthent') || localStorage.getItem('token')  ){
    return next();
  }
  next('/auth/login');
});

export default router