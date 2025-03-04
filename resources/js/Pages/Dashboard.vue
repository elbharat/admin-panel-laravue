<script setup>
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/ui/card.vue';
import { CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/Components/ui/card.vue';
import Button from '@/Components/ui/button.vue';
import Table from '@/Components/ui/table.vue';
import { TableHeader, TableBody, TableFooter, TableHead, TableRow, TableCell } from '@/Components/ui/table.vue';
import { 
  TrendingUp, 
  TrendingDown, 
  Users, 
  ShoppingCart, 
  Package, 
  DollarSign,
  BarChart2,
  PieChart,
  Activity
} from 'lucide-vue-next';
</script>

<template>
  <Head title="Dashboard" />

  <ModernAdminLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <Button>
          <span class="mr-2">Generate Report</span>
          <BarChart2 class="h-4 w-4" />
        </Button>
      </div>
    </template>

    <!-- Stats Cards -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
      <Card className="overflow-hidden border-l-4 border-l-blue-500">
        <CardContent class="p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">TOTAL USERS</p>
              <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">1,234</h3>
              <p class="mt-1 flex items-center text-sm text-green-600 dark:text-green-400">
                <TrendingUp class="mr-1 h-4 w-4" />
                <span>12% increase</span>
              </p>
            </div>
            <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
              <Users class="h-8 w-8 text-blue-600 dark:text-blue-300" />
            </div>
          </div>
        </CardContent>
      </Card>

      <Card className="overflow-hidden border-l-4 border-l-green-500">
        <CardContent class="p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">REVENUE</p>
              <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">$12,345</h3>
              <p class="mt-1 flex items-center text-sm text-green-600 dark:text-green-400">
                <TrendingUp class="mr-1 h-4 w-4" />
                <span>8.2% increase</span>
              </p>
            </div>
            <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
              <DollarSign class="h-8 w-8 text-green-600 dark:text-green-300" />
            </div>
          </div>
        </CardContent>
      </Card>

      <Card className="overflow-hidden border-l-4 border-l-purple-500">
        <CardContent class="p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ORDERS</p>
              <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">567</h3>
              <p class="mt-1 flex items-center text-sm text-red-600 dark:text-red-400">
                <TrendingDown class="mr-1 h-4 w-4" />
                <span>3.1% decrease</span>
              </p>
            </div>
            <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900">
              <ShoppingCart class="h-8 w-8 text-purple-600 dark:text-purple-300" />
            </div>
          </div>
        </CardContent>
      </Card>

      <Card className="overflow-hidden border-l-4 border-l-amber-500">
        <CardContent class="p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">PRODUCTS</p>
              <h3 class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">890</h3>
              <p class="mt-1 flex items-center text-sm text-green-600 dark:text-green-400">
                <TrendingUp class="mr-1 h-4 w-4" />
                <span>5.3% increase</span>
              </p>
            </div>
            <div class="rounded-full bg-amber-100 p-3 dark:bg-amber-900">
              <Package class="h-8 w-8 text-amber-600 dark:text-amber-300" />
            </div>
          </div>
        </CardContent>
      </Card>
    </div>

    <!-- Charts and Tables Section -->
    <div class="mt-8 grid gap-6 lg:grid-cols-2">
      <!-- Recent Orders -->
      <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
          <div>
            <CardTitle class="text-xl">Recent Orders</CardTitle>
            <CardDescription>Latest transactions in your store</CardDescription>
          </div>
          <Button variant="outline" size="sm">View All</Button>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Order ID</TableHead>
                <TableHead>Customer</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Date</TableHead>
                <TableHead>Amount</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow>
                <TableCell class="font-medium">#ORD-001</TableCell>
                <TableCell>John Doe</TableCell>
                <TableCell>
                  <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                    Completed
                  </span>
                </TableCell>
                <TableCell>2025-03-01</TableCell>
                <TableCell>$120.00</TableCell>
                <TableCell>
                  <Button size="sm" variant="outline">View</Button>
                </TableCell>
              </TableRow>
              <TableRow>
                <TableCell class="font-medium">#ORD-002</TableCell>
                <TableCell>Jane Smith</TableCell>
                <TableCell>
                  <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                    Processing
                  </span>
                </TableCell>
                <TableCell>2025-03-02</TableCell>
                <TableCell>$85.50</TableCell>
                <TableCell>
                  <Button size="sm" variant="outline">View</Button>
                </TableCell>
              </TableRow>
              <TableRow>
                <TableCell class="font-medium">#ORD-003</TableCell>
                <TableCell>Robert Johnson</TableCell>
                <TableCell>
                  <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                    Shipped
                  </span>
                </TableCell>
                <TableCell>2025-03-03</TableCell>
                <TableCell>$210.75</TableCell>
                <TableCell>
                  <Button size="sm" variant="outline">View</Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      <!-- Activity Overview -->
      <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
          <div>
            <CardTitle class="text-xl">Activity Overview</CardTitle>
            <CardDescription>Recent activity on your platform</CardDescription>
          </div>
          <Activity class="h-4 w-4 text-gray-500 dark:text-gray-400" />
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div class="flex items-start space-x-4">
              <div class="relative mt-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                  <Users class="h-4 w-4 text-blue-600 dark:text-blue-300" />
                </div>
                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 ring-1 ring-white dark:ring-gray-800"></span>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">New user registered</h4>
                  <span class="text-xs text-gray-500 dark:text-gray-400">2 min ago</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">John Smith created a new account</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="relative mt-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900">
                  <ShoppingCart class="h-4 w-4 text-purple-600 dark:text-purple-300" />
                </div>
                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 ring-1 ring-white dark:ring-gray-800"></span>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">New order placed</h4>
                  <span class="text-xs text-gray-500 dark:text-gray-400">15 min ago</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Order #ORD-004 was placed for $350.00</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="relative mt-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                  <DollarSign class="h-4 w-4 text-green-600 dark:text-green-300" />
                </div>
                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 ring-1 ring-white dark:ring-gray-800"></span>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Payment received</h4>
                  <span class="text-xs text-gray-500 dark:text-gray-400">1 hour ago</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Payment for order #ORD-002 was received</p>
              </div>
            </div>
            
            <div class="flex items-start space-x-4">
              <div class="relative mt-1">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900">
                  <Package class="h-4 w-4 text-amber-600 dark:text-amber-300" />
                </div>
                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 ring-1 ring-white dark:ring-gray-800"></span>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Product updated</h4>
                  <span class="text-xs text-gray-500 dark:text-gray-400">3 hours ago</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Product "Wireless Headphones" was updated</p>
              </div>
            </div>
          </div>
        </CardContent>
        <CardFooter>
          <Button variant="outline" class="w-full">View All Activity</Button>
        </CardFooter>
      </Card>
    </div>

    <!-- Additional Cards -->
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <!-- Top Selling Products -->
      <Card>
        <CardHeader class="pb-2">
          <CardTitle class="text-xl">Top Selling Products</CardTitle>
          <CardDescription>Products with the highest sales</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800">
                  <Package class="h-5 w-5 text-gray-600 dark:text-gray-400" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Wireless Headphones</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Electronics</p>
                </div>
              </div>
              <p class="text-sm font-medium text-gray-900 dark:text-white">$129.99</p>
            </div>
            
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800">
                  <Package class="h-5 w-5 text-gray-600 dark:text-gray-400" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Smart Watch</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Electronics</p>
                </div>
              </div>
              <p class="text-sm font-medium text-gray-900 dark:text-white">$199.99</p>
            </div>
            
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800">
                  <Package class="h-5 w-5 text-gray-600 dark:text-gray-400" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Laptop Backpack</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Accessories</p>
                </div>
              </div>
              <p class="text-sm font-medium text-gray-900 dark:text-white">$59.99</p>
            </div>
            
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800">
                  <Package class="h-5 w-5 text-gray-600 dark:text-gray-400" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">Bluetooth Speaker</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Electronics</p>
                </div>
              </div>
              <p class="text-sm font-medium text-gray-900 dark:text-white">$79.99</p>
            </div>
          </div>
        </CardContent>
        <CardFooter>
          <Button variant="outline" class="w-full">View All Products</Button>
        </CardFooter>
      </Card>

      <!-- Recent Customers -->
      <Card>
        <CardHeader class="pb-2">
          <CardTitle class="text-xl">Recent Customers</CardTitle>
          <CardDescription>Newly registered customers</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300">JD</div>
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">John Doe</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">john.doe@example.com</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-300">JS</div>
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Jane Smith</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">jane.smith@example.com</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300">RJ</div>
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Robert Johnson</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">robert.johnson@example.com</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900 dark:text-amber-300">EW</div>
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Emily Williams</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">emily.williams@example.com</p>
              </div>
            </div>
          </div>
        </CardContent>
        <CardFooter>
          <Button variant="outline" class="w-full">View All Customers</Button>
        </CardFooter>
      </Card>

      <!-- Quick Stats -->
      <Card>
        <CardHeader class="pb-2">
          <CardTitle class="text-xl">Quick Stats</CardTitle>
          <CardDescription>Performance metrics</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div>
              <div class="mb-1 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Conversion Rate</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">3.2%</p>
              </div>
              <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-full w-[32%] rounded-full bg-blue-500"></div>
              </div>
            </div>
            
            <div>
              <div class="mb-1 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Customer Retention</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">78%</p>
              </div>
              <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-full w-[78%] rounded-full bg-green-500"></div>
              </div>
            </div>
            
            <div>
              <div class="mb-1 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Cart Abandonment</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">42%</p>
              </div>
              <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-full w-[42%] rounded-full bg-amber-500"></div>
              </div>
            </div>
            
            <div>
              <div class="mb-1 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900 dark:text-white">Average Order Value</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">$85</p>
              </div>
              <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="h-full w-[65%] rounded-full bg-purple-500"></div>
              </div>
            </div>
          </div>
        </CardContent>
        <CardFooter>
          <Button variant="outline" class="w-full">View Detailed Analytics</Button>
        </CardFooter>
      </Card>
    </div>
  </ModernAdminLayout>
</template>
