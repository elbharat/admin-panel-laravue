<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/ui/card.vue';
import { CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/Components/ui/card.vue';
import Button from '@/Components/ui/button.vue';
import Table from '@/Components/ui/table.vue';
import { TableHeader, TableBody, TableFooter, TableHead, TableRow, TableCell } from '@/Components/ui/table.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-foreground">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>Total Users</CardTitle>
                            <CardDescription>Active users in your platform</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p class="text-3xl font-bold">1,234</p>
                        </CardContent>
                    </Card>
                    
                    <Card>
                        <CardHeader>
                            <CardTitle>Revenue</CardTitle>
                            <CardDescription>Monthly revenue</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p class="text-3xl font-bold">$12,345</p>
                        </CardContent>
                    </Card>
                    
                    <Card>
                        <CardHeader>
                            <CardTitle>Orders</CardTitle>
                            <CardDescription>Total orders this month</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p class="text-3xl font-bold">567</p>
                        </CardContent>
                    </Card>
                    
                    <Card>
                        <CardHeader>
                            <CardTitle>Products</CardTitle>
                            <CardDescription>Total active products</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <p class="text-3xl font-bold">890</p>
                        </CardContent>
                    </Card>
                </div>
                
                <div class="mt-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Recent Orders</CardTitle>
                            <CardDescription>Latest transactions in your store</CardDescription>
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
                                        <TableCell>#ORD-001</TableCell>
                                        <TableCell>John Doe</TableCell>
                                        <TableCell>
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
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
                                        <TableCell>#ORD-002</TableCell>
                                        <TableCell>Jane Smith</TableCell>
                                        <TableCell>
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
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
                                        <TableCell>#ORD-003</TableCell>
                                        <TableCell>Robert Johnson</TableCell>
                                        <TableCell>
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
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
                        <CardFooter>
                            <Button variant="outline">View All Orders</Button>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
