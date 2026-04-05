import { Head, Link, router } from '@inertiajs/react';
import { useState, type ReactElement } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Input } from '@/components/ui/input';
import { Plus, FolderTree } from 'lucide-react';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';
import { Fragment } from 'react';

interface Category {
    id: number;
    name: string;
    slug: string;
    description: string;
    created_at: string;
    updated_at: string;
    posts_count: number;
    children?: Category[];
}

interface Props {
    categories: Category[];
    filters?: {
        search: string;
    };
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Categories'
    },
];

export default function Index({ categories, filters = { search: '' } }: Props) {
    const [search, setSearch] = useState(filters.search);

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(
            route('admin.categories.index'),
            { search: value },
            { preserveState: true }
        );
    };

    const renderCategories = (categories: Category[]): ReactElement[] => {
        return categories.map((category) => (
            <Fragment key={category.id}>
                <TableRow>
                    <TableCell>{category.name}</TableCell>
                    <TableCell>{category.slug}</TableCell>
                    <TableCell>{category.description}</TableCell>
                    <TableCell>
                        {format(new Date(category.created_at), 'dd MMMM yyyy', {
                            locale: id,
                        })}
                    </TableCell>
                    <TableCell>
                        <div className="flex space-x-2">
                            <Link href={route('admin.categories.edit', category.id)}>
                                <Button variant="outline" size="sm">
                                    Edit
                                </Button>
                            </Link>
                            <Link href={route('admin.categories.show', category.id)}>
                                <Button variant="outline" size="sm">
                                    View
                                </Button>
                            </Link>
                        </div>
                    </TableCell>
                </TableRow>
                {category.children && renderCategories(category.children)}
            </Fragment>
        ));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />

            <div className="p-4">
                <div className="flex justify-between items-center mb-4">
                    <div>
                        <h1 className="text-2xl font-bold">Categories</h1>
                        <p className="text-muted-foreground">Manage and create categories for your content</p>
                    </div>
                    <Link href={route('admin.categories.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Create Category
                        </Button>
                    </Link>
                </div>

                <div className="rounded-lg shadow border p-4 mb-4">
                    <div className="grid grid-cols-1 gap-4">
                        <div>
                            <Input
                                placeholder="Search category..."
                                value={search}
                                onChange={(e) => handleSearch(e.target.value)}
                                className="w-full text-gray-200 placeholder:text-gray-500"
                            />
                        </div>
                    </div>
                </div>

                <div className="rounded-lg shadow border">
                    {categories.length === 0 ? (
                        <div className="flex flex-col items-center justify-center py-12 px-4 rounded-lg">
                            <FolderTree className="h-12 w-12 text-gray-400 mb-4" />
                            <h3 className="text-lg font-medium mb-1">No categories found</h3>
                            <p className="text-center mb-4">
                                {search
                                    ? 'No categories found with your search'
                                    : 'Start by creating a category to organize your content'}
                            </p>
                            <Link href={route('admin.categories.create')}>
                                <Button>
                                    <Plus className="mr-2 h-4 w-4" />
                                    Create First Category
                                </Button>
                            </Link>
                        </div>
                    ) : (
                        <Table>
                            <TableHeader>
                                <TableRow className="border-b">
                                    <TableHead>Name</TableHead>
                                    <TableHead>Slug</TableHead>
                                    <TableHead>Description</TableHead>
                                    <TableHead>Created At</TableHead>
                                    <TableHead>Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {renderCategories(categories)}
                            </TableBody>
                        </Table>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
