import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import Form from './Form';

interface Props {
    category: {
        id: number;
        name: string;
        description: string;
    };
}

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
        title: 'Edit',
    },
];

export default function Edit({ category }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Category" />

            <div className="p-4">
                <Form category={category} />
            </div>
        </AppLayout>
    );
}
