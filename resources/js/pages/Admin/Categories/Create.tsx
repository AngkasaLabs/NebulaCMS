import Form from './Form';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Categories',
        href: route('admin.categories.index'),
    },
    {
        title: 'Create',
    },
];

export default function Create() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Category" />
            <div className="p-4">
                <Form />
            </div>
        </AppLayout>
    );
}
