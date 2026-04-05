import AppLayout from '@/layouts/app-layout';
import Form from './Form';
import { Head } from '@inertiajs/react';

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Tags',
        href: route('admin.tags.index'),
    },
    {
        title: 'Create',
    },
];
export default function Create() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Tag" />
            <div className="p-4">
                <Form />
            </div>
        </AppLayout>
    );
}